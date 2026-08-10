<script setup lang="ts">
import { useRoute } from 'vue-router';

const route = useRoute();
</script>

<template>
	<NuxtApp>
		<router-view :key="route.name"></router-view>
	</NuxtApp>
</template>
