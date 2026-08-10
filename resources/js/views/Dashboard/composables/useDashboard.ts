import { ref } from 'vue';
import { DashboardService } from '../../../services/FinanceService';
import { DashboardModel } from '../../../models/DashboardModel';

export const useDashboard = () => {
    const dashboard = ref<DashboardModel | null>(null);
    const loading = ref(false);
    const error = ref('');

    const getDashboard = async () => {
        loading.value = true;
        error.value = '';

        try {
            const { data } =
                await DashboardService.getDashboard();

            dashboard.value =
                DashboardModel.fromResponse(data.data);
        } catch (err: any) {
            error.value =
                err?.response?.data?.message ??
                'Unable to load dashboard.';
        } finally {
            loading.value = false;
        }
    };

    return {
        dashboard,
        loading,
        error,
        getDashboard,
    };
};