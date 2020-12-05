<template>
    <div class="circle-calculator">
        <div class="circle-calculator__inner">
            <h1 class="circle-calculator__heading">Area of a Circle</h1>
            <form class="circle-calculator__form" method="GET">
                <label for="circle-radius">Circle Radius</label>
                <input type="number" name="radius" id="circle-radius" v-model="radius">
                <button type="submit">Calculate Area</button>
            </form>
            <output class="circle-calculator__output" v-if="result">
                Area = {{result}}
            </output>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CircleCalculator',
    data() {
        return {
            radius: null,
            result: null
        }
    },
	created() {
        var phpDataset = document.body.dataset;
        this.radius = phpDataset.calcRadius;
        this.result = phpDataset.calcResult;
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
    &__form {
        /* TODO */
        label {
            display: block;
        }
        input {
            display: block;
        }
        button {
            display: block;
        }
    }
    &__output {
        display: block;
        margin: 1rem 0 0 0;
    }
}
</style>