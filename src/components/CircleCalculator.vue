<template>
    <div class="circle-calculator">
        <section class="circle-calculator__inner">
            <h1 class="circle-calculator__heading">Area of a Circle</h1>
            <form class="circle-calculator__form" method="GET">
                <label for="circle-radius">Circle Radius</label>
                <input type="number" name="radius" id="circle-radius" step="any" v-model="radius">
                <div class="button-set">
                    <button type="submit" class="button">Calculate Area</button>
                </div>
            </form>
            <output class="circle-calculator__output" v-if="result">
                Area = {{result}}
            </output>
            <output class="circle-calculator__output circle-calculator__output--error" v-else-if="error">
                Error: {{error}}
            </output>
        </section>
    </div>
</template>

<script>
export default {
    name: 'CircleCalculator',
    data() {
        return {
            radius: null,
            result: null,
            error: null
        }
    },
	created() {
        var phpDataset = document.body.dataset;
        this.radius = phpDataset.calcRadius;
        this.result = phpDataset.calcResult;
        this.error = phpDataset.calcError;
	}
}
</script>

<style lang="scss">
.circle-calculator {
	--bd-filter: blur(3px);
    width: 80%;
    max-width: 360px;
    max-height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #ffffffe0;
	backdrop-filter: var(--bd-filter);
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    &__heading {
        margin: 0 0 1rem 0;
    }
    &__output {
        display: block;
        margin: 1rem 0 0 0;
        &--error {
            color: #980000;
        }
    }
}
</style>