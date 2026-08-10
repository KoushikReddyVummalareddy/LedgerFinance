import { defineStore } from 'pinia';
import { ref } from 'vue';

const STORAGE_KEY = 'ov-sidenav-collapsed';

function readCollapsed(): boolean {
	try {
		return localStorage.getItem(STORAGE_KEY) === 'true';
	} catch {
		return false;
	}
}

export const useUtilStore = defineStore('util', () => {
	const loading = ref(false);
	const sideNavCollapsed = ref(readCollapsed());

	function setLoading(value: boolean) {
		loading.value = value;
	}

	function toggleSideNav() {
		sideNavCollapsed.value = !sideNavCollapsed.value;
		try {
			localStorage.setItem(STORAGE_KEY, String(sideNavCollapsed.value));
		} catch {
			// ignore
		}
	}

	return { loading, setLoading, sideNavCollapsed, toggleSideNav };
});
