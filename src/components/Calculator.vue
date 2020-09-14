<template>
    <div class="calculator">
        <output class="calculator__display" form="calculator__buttons">
            <div class="calculator__problem" v-html="equation"></div>
            <div :class="['calculator__answer', 'calculator__answer--' + answerSize]">{{answer}}</div>
        </output>
        <form class="calculator__buttons" id="calculator__buttons" @submit.prevent="solve">
            <button type="button" class="calculator__button calculator__button--op" @click="per">%</button>
            <button type="button" class="calculator__button calculator__button--op" @click="ce">CE</button>
            <button type="button" class="calculator__button calculator__button--op" @click="clear">C</button>
            <button type="button" class="calculator__button calculator__button--op" @click="back">&#8612;</button>
            <button type="button" class="calculator__button calculator__button--op" @click="sqrt">&radic;</button>
            <button type="button" class="calculator__button calculator__button--op" @click="sqr">x<sup>2</sup></button>
            <button type="button" class="calculator__button calculator__button--op" @click="pow">x<sup>y</sup></button>
            <button type="button" class="calculator__button calculator__button--op" @click="op('/')">&divide;</button>
            <button type="button" class="calculator__button" @click="ent('7')">7</button>
            <button type="button" class="calculator__button" @click="ent('8')">8</button>
            <button type="button" class="calculator__button" @click="ent('9')">9</button>
            <button type="button" class="calculator__button calculator__button--op" @click="op('*')">&times;</button>
            <button type="button" class="calculator__button" @click="ent('4')">4</button>
            <button type="button" class="calculator__button" @click="ent('5')">5</button>
            <button type="button" class="calculator__button" @click="ent('6')">6</button>
            <button type="button" class="calculator__button calculator__button--op" @click="op('-')">&minus;</button>
            <button type="button" class="calculator__button" @click="ent('1')">1</button>
            <button type="button" class="calculator__button" @click="ent('2')">2</button>
            <button type="button" class="calculator__button" @click="ent('3')">3</button>
            <button type="button" class="calculator__button calculator__button--op" @click="op('+')">+</button>
            <button type="button" class="calculator__button" @click="sign">&#8723;</button>
            <button type="button" class="calculator__button" @click="ent('0')">0</button>
            <button type="button" class="calculator__button" @click="dec">.</button>
            <button type="submit" class="calculator__button calculator__button--submit">=</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'Calculator',
	data() {
        return {
            entry: '',
            problem: [],
            answer: 0,
            onOp: false,
            onDec: false,
            onPow: false
        }
	},
	computed: {
		equation() {
            // Format numbers and symbols for display
            var equation = this.problem.slice();
			for (var x in equation) {
				if (!isNaN(equation[x])) {
					equation[x] = this.$options.methods.addCommas(equation[x]);
				} else if (equation[x] === '/') {
					equation[x] = '&divide;'
				} else if  (equation[x] === '*') {
					equation[x] = '&times;'
				} else if  (equation[x] === '-') {
					equation[x] = '&minus;'
				}
			}
			return equation.join(' ');
		},
		answerSize() {
            // Scale text to fit; returns CSS class ending
			var answerLen = this.answer.toString().split('').length;
			if (answerLen < 14) {
				return 'large';
			} else if (answerLen < 18) {
				return 'medium';
			} else if (answerLen < 22) {
				return 'small';
			}
			return 'xsmall';
		}
	},
	methods: {
		clear() {
            // Clear button
			this.entry = '';
			this.problem = [];
			this.answer = 0;
			this.onOp = false;
			this.onDec = false;
			this.onPow = false;
		},
		ce() {
            // Clear entry button
			this.onDec = false;
			if (!isNaN(this.problem[this.problem.length - 1])) {
				this.problem.pop();
			}
			this.onOp = true;
			this.entry = '';
			this.answer = 0;
		},
		ent(char) {
            // Number button
			this.onOp = false;
			if (this.problem.length === 1 || this.entry === Infinity) {
				this.ce();
			}
			if (this.onDec && !this.entry.toString().includes('.')) {
				this.entry += '.';
			}
			this.entry += char;
			this.entry = Number(this.entry);
			this.answer = this.addCommas(this.entry);
		},
		dec() {
            // Decimal button
			this.onDec = true;
			if (!this.entry) {
				this.answer = '0.';
			} else {
				this.answer = this.addCommas(String(this.entry) + '.');
			}
		},
		op(char) {
            // Add, subtract, multiply, or divide button
			if (this.problem.length === 0 && this.entry === '') return;
			this.powSolve();
			if (this.onOp) {
				this.problem.pop();
			}
			this.onPow = false;
			this.onDec = false;
			this.onOp = true;
			if (this.entry !== '') {
				this.problem.push(this.entry);
			}
			this.problem.push(char);
			this.entry = '';
			this.answer = 0;
		},
		sign() {
            // Positive/negative button
			if (this.entry) {
				this.entry *= -1;
				this.answer = this.addCommas(this.entry);
			}
		},
		per() {
            // Percent button
			var prevNum = this.problem[this.problem.length - 2];
            if (this.entry) {
                if (!isNaN(prevNum)) {
                    this.entry = prevNum * (this.entry / 100);
                    this.answer = this.addCommas(this.entry);
                } else {
                    this.ce();
                }
            }
		},
		sqrt() {
            // Square root button
			if (this.entry) {
				this.entry = Math.sqrt(this.entry);
				this.answer = this.addCommas(this.entry);
			}
		},
		sqr() {
            // Square button
			if (this.entry) {
				this.entry = Math.pow(this.entry, 2);
				this.answer = this.addCommas(this.entry);
			}
		},
		pow() {
            // Caret/power button
			if (this.entry) {
				this.onDec = false;
				this.onPow = true;
				this.problem.push(this.entry);
				this.problem.push('^');
				this.entry = '';
				this.answer = 0;
			}
		},
		powSolve() {
            // Calculate power entered
			if (this.onPow) {
				this.onPow = false;
				this.problem.pop();
				this.entry = Math.pow(this.problem.pop(), this.entry);
				this.answer = this.addCommas(this.entry);
			}
		},
		back() {
            // Backspace button
			if (this.entry) {
				var newEntry = this.entry.toString().split('');
				newEntry.pop();
				this.entry = Number(newEntry.join(''));
				this.answer = this.addCommas(this.entry);
				if (!this.entry) {
					this.onOp = true;
				}
			}
		},
		addCommas(nStr) {
            // Format numbers
			nStr += '';
			var x = nStr.split('.');
			var x1 = x[0];
			var x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		},
		solve() {
            // Solve entered equation
			this.powSolve();
			this.onOp = false;
			this.onDec = false;
			if (this.entry === '') {
				this.entry = 0;
			}
			this.problem.push(this.entry);
			this.entry = '';
			try {
				var answer = eval(this.problem.join(' '));
				this.answer = this.addCommas(answer);
				this.problem = [answer];
			} catch(err) {
				this.answer = 'Error';
			}
		}
    },
    mounted() {
        // Keyboard input
        var keysDown = {};
        window.addEventListener('keydown', (evt) => {
            keysDown[evt.key] = true;
            switch(evt.key) {
                case '0': this.ent('0'); break;
                case '1': this.ent('1'); break;
                case '2': this.ent('2'); break;
                case '3': this.ent('3'); break;
                case '4': this.ent('4'); break;
                case '5': this.ent('5'); break;
                case '6': this.ent('6'); break;
                case '7': this.ent('7'); break;
                case '8': this.ent('8'); break;
                case '9': this.ent('9'); break;
                case '.': this.dec(); break;
                case '%': this.per(); break;
                case 'Delete': this.ce(); break;
                case 'Escape': this.clear(); break;
                case 'Backspace': this.back(); break;
                case '^': this.pow(); break;
                case '/': this.op('/'); break;
                case '*': this.op('*'); break;
                case '-': this.op('-'); break;
                case '+': this.op('+'); break;
                case '=': this.solve(); break;
                case 'Enter': this.solve(); break;
            }
        });
        window.addEventListener('keyup', (evt) => {
            delete keysDown[evt.key];
        });
    }
}
</script>

<style lang="scss">
.calculator {
	--gap: 7px;
	display: grid;
	grid-template-rows: auto minmax(0, 1fr);
	grid-template-columns: 1fr;
    font-size: calc(var(--gap) * 2);
	max-width: 420px;
	max-height: 100vh;
	backdrop-filter: blur(3px);
	&__display {
		font-size: 1.6em;
        display: block;
		text-align: right;
		color: white;
		background-color: #111111e0;
		padding: var(--gap);
	}
	&__problem {
		font-size: 0.6em;
		line-height: 1em;
		padding: var(--gap);
		min-height: calc(1em + (var(--gap) * 2)); /* Line height and padding */
		color: darken(white, 20%);
	}
	&__answer {
		padding: var(--gap);
		line-height: calc(var(--gap) * 5);
		&--large {font-size: 1.5em;}
		&--medium {font-size: 1.1em;}
		&--small {font-size: 0.9em;}
		&--xsmall {font-size: 0.7em;}
	}
	&__buttons {
		display: grid;
		grid-template-rows: repeat(6, 16.6666%);
		grid-template-columns: repeat(4, 1fr);
    }
    &__button {
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
        &:hover {background: darken(#dfdfdfe0, 10%);}
        &:active {background: darken(#dfdfdfe0, 20%);}
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
        &::before, &::after {
            /* Button aspect ratio */
            content: '';
            display: inline-block;
            width: 1px;
            height: 0;
            padding: 80% 0 0 0;
        }
        sup {
            /* Exponents */
            position: relative;
            top: -0.5em;
            font-size: .6em;
        }
    }
}

@media (min-width: 360px) {
	.calculator {
		--gap: 9px;
	}
}

@media (min-width: 420px) {
	.calculator {
		--gap: 10px;
	}
}
</style>