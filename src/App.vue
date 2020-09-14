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
	background-image: url('./img/background/360x640.jpg');
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

/* Responsive background image */
@media (min-width: 360px) {
	html {background-image: url('./img/background/540x960.jpg');}
}
@media (min-width: 540px) and (orientation: portrait) {
	html {background-image: url('./img/background/720x1280.jpg');}
}
@media (min-width: 540px) and (orientation: landscape) {
	html {background-image: url('./img/background/720x480.jpg');}
}
@media (min-width: 720px) {
	html {background-image: url('./img/background/1024x1821.jpg');}
}
@media (min-width: 1024px) {
	html {background-image: url('./img/background/1280x853.jpg');}
}
@media (min-width: 1280px) {
	html {background-image: url('./img/background/1920x1280.jpg');}
}
@media (min-width: 1920px) {
	html {background-image: url('./img/background/2560x1707.jpg');}
}
@media (min-width: 2560px) {
	html {background-image: url('./img/background/3840x2560.jpg');}
}

/* Error pages */
.error-card {
	width: 80%;
	max-width: 480px;
	margin: 2rem auto;
	padding: 2rem;
	text-align: center;
	background-color: white;
	box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	p {
		margin: 0;
	}
	.error-icon {
		display: block;
		width: 30%;
		height: auto;
		margin: 2rem auto;
	}
}
</style>
