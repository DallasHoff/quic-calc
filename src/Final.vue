<template>
	<div id="app">
		<circle-calculator></circle-calculator>
	</div>
</template>

<script>
import CircleCalculator from '@/components/CircleCalculator.vue';

export default {
	name: 'App',
	components: {
		CircleCalculator
	}
}
</script>

<style lang="scss">
@import 'app';
</style>
