<template>
	<div id="app">
		<calculator></calculator>
	</div>
</template>

<script>
import Calculator from '@/components/Calculator.vue';

export default {
	name: 'App',
	components: {
		Calculator
	}
}
</script>

<style lang="scss">
* {box-sizing: border-box;}
html {
	font-size: 16px;
	font-family: 'Varela Round', Helvetica, Arial, sans-serif;
	text-size-adjust: none;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	word-wrap: break-word;
	padding: 0;
	margin: 0;
	background-color: #f3f3f3;
	background-image: url('./img/background/1920x1280.jpg'); /* TODO: make responsive */
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
}
body {
	padding: 0;
	margin: 0;
	background: none;
}
#app {
	display: flex;
	align-items: center;
	justify-content: center;
	height: 100vh;
	.calculator {
		flex: 1 0 0;
	}
}
</style>
