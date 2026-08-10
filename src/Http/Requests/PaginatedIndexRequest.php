<?php

namespace Src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginatedIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'deleted' => ['sometimes', Rule::in([true, false, 'true', 'false', 1, 0, '1', '0'])],
            'page' => 'sometimes|integer|min:1',
            'size' => 'sometimes|integer|min:1|max:9999',
            'pagination' => 'sometimes|boolean',
            'name' => 'nullable|string',
            'order' => 'nullable|string|in:product_id,name,created_at',
            'comando' => 'nullable|integer|exists:comandi,id',
        ];
    }
    /**
     * Prepare the data for validation.
     *
     * Normalizes pagination and deleted parameters:
     * - Ensures page and size are integers with defaults
     * - Converts 'deleted' query parameter to boolean (true/false) or null
     * - Converts 'pagination' query parameter to boolean 
     * 
     * @return void
     */
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        if ($this->has('deleted')) {
            $this->merge([
                'deleted' => match ($this->input('deleted')) {
                    'true' => true,
                    'false' => false,
                    default => null,
                }
            ]);
        }
        if ($this->has('pagination')) {
            $value = $this->input('pagination');
            $converted = match (true) {
                $value === true || $value === false => $value,
                $value === 'true' || $value === '1' || $value === 1 => true,
                $value === 'false' || $value === '0' || $value === 0 => false,
                default => $value,
            };
            $this->merge(['pagination' => $converted]);
        }
    }
    /**
     * Get the validated page number
     *
     * @return int
     */
    public function getPage(): int
    {
        return (int) $this->input('page', 1);
    }
    /**
     * Get the validated page size
     *
     * @return int
     */
    public function getSize(): int
    {
        return (int) $this->input('size', 10);
    }
    /**
     * Get the validated deleted filter value
     *
     * @return bool|null Returns true for deleted only, false for non-deleted only, null for all
     */
    public function getDeleted(): ?bool
    {
        if (! $this->has('deleted')) {
            return null;
        }
        $value = $this->input('deleted');
        if (is_bool($value)) {
            return $value;
        }
        return match (strtolower((string) $value)) {
            'true', '1' => true,
            'false', '0' => false,
            default => null,
        };
    }
    /**
     * Get the pagination flag
     *
     * This parameter is optional. Returns null if not provided, allowing services to use their default.
     * 
     * @return bool|null Returns false if pagination should be disabled (return all items), true if enabled, null if not provided
     */
    public function getPagination(): ?bool
    {
        return $this->has('pagination') ? $this->input('pagination') : null;
    }

    /**
     * Get product name filter (used for searching products by name).
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->input('name');
    }

    /**
     * Get ordering key (products index). Possible values: product_id, name, created_at.
     *
     * @return string|null
     */
    public function getOrder(): ?string
    {
        return $this->input('order');
    }
}
