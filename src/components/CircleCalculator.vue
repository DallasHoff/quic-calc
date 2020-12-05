<template>
    <div class="circle-calculator">
        <div class="circle-calculator__inner"></div>
    </div>
</template>

<script>
export default {
    name: 'CircleCalculator',
    data() {
        return {
            php: {}
        }
    },
	created() {
        Object.assign(this.php, document.body.dataset);
	}
}
</script>

<style lang="scss">
.circle-calculator {
	--bd-filter: blur(3px);
    width: 80%;
    min-width: 240px;
    max-width: 480px;
    max-height: 100%;
    overflow-y: auto;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #ffffffe0;
	backdrop-filter: var(--bd-filter);
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
</style>