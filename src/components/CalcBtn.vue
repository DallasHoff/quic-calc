<template>
    <button :type="type" :class="['calculator__button', 'calculator__button--' + version]" :style="{'grid-area': area}" @keypress.enter.prevent>
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: 'CalcBtn',
    props: ['version', 'area'],
    computed: {
        type() {
            return this.version === 'submit' ? 'submit' : 'button';
        }
    }
}
</script>

<style lang="scss">
.calculator__button {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-size: 1.2em;
    color: #111111;
    border: 1px solid #7f7f7f;
    margin: 0;
    padding: 0;
    background: #dfdfdfe0;
    user-select: none;
    &:hover {background: darken(#dfdfdfe0, 10%);}
    &:active {background: darken(#dfdfdfe0, 20%);}
    /* Version color variations */
    &--op {
        background: #c6e9afe0;
        &:hover {background: darken(#c6e9afe0, 10%);}
        &:active {background: darken(#c6e9afe0, 20%);}
    }
    &--submit {
        background: #71c837e0;
        &:hover {background: darken(#71c837e0, 10%);}
        &:active {background: darken(#71c837e0, 20%);}
    }
    /* Button aspect ratio */
    &::before, &::after {
        content: '';
        display: inline-block;
        width: 1px;
        height: 0;
        padding: 80% 0 0 0;
    }
    /* Exponents */
    sup {
        position: relative;
        top: -0.5em;
        font-size: .6em;
    }
}
</style>