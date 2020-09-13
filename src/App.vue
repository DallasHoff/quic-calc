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
	-webkit-text-size-adjust: none;
	-moz-text-size-adjust: none;
	-ms-text-size-adjust: none;
	text-size-adjust: none;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	word-wrap: break-word;
	padding: 0;
	margin: 0;
	background-color: #f3f3f3;
	background-image: url('./img/background/1920h.jpg'); /* TODO: make responsive */
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
}
body {
	padding: 0;
	margin: 0;
	background: none;
}

/* TODO: Stopgap to center calculator before layout work is done */
#app {
	display: flex;
	align-items: center;
	height: 100vh;
	.calculator {
		flex: 1 0 auto;
	}
}
</style>
