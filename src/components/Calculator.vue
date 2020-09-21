<template>
    <div class="calculator">
        <output class="calculator__display" form="calculator__buttons">
            <div class="calculator__problem" v-html="equation"></div>
            <div :class="['calculator__answer', 'calculator__answer--' + answerSize]">{{answer}}</div>
        </output>
        <form class="calculator__buttons" id="calculator__buttons" @submit.prevent="solve">
            <calc-btn version="op" area="per" @click.native="per">%</calc-btn>
            <calc-btn version="op" area="ce" @click.native="ce">CE</calc-btn>
            <calc-btn version="op" area="c" @click.native="clear">C</calc-btn>
            <calc-btn version="op" area="back" @click.native="back">&#8612;</calc-btn>
            <calc-btn version="op" area="sqrt" @click.native="sqrt">&radic;</calc-btn>
            <calc-btn version="op" area="sqr" @click.native="sqr">x<sup>2</sup></calc-btn>
            <calc-btn version="op" area="pow" @click.native="pow">x<sup>y</sup></calc-btn>
            <calc-btn version="op" area="div" @click.native="op('/')">&divide;</calc-btn>
            <calc-btn version="num" area="n7" @click.native="num('7')">7</calc-btn>
            <calc-btn version="num" area="n8" @click.native="num('8')">8</calc-btn>
            <calc-btn version="num" area="n9" @click.native="num('9')">9</calc-btn>
            <calc-btn version="op" area="mul" @click.native="op('*')">&times;</calc-btn>
            <calc-btn version="num" area="n4" @click.native="num('4')">4</calc-btn>
            <calc-btn version="num" area="n5" @click.native="num('5')">5</calc-btn>
            <calc-btn version="num" area="n6" @click.native="num('6')">6</calc-btn>
            <calc-btn version="op" area="sub" @click.native="op('-')">&minus;</calc-btn>
            <calc-btn version="num" area="n1" @click.native="num('1')">1</calc-btn>
            <calc-btn version="num" area="n2" @click.native="num('2')">2</calc-btn>
            <calc-btn version="num" area="n3" @click.native="num('3')">3</calc-btn>
            <calc-btn version="op" area="add" @click.native="op('+')">+</calc-btn>
            <calc-btn version="num" area="sign" @click.native="sign">&#8723;</calc-btn>
            <calc-btn version="num" area="n0" @click.native="num('0')">0</calc-btn>
            <calc-btn version="num" area="dec" @click.native="dec">.</calc-btn>
            <calc-btn version="submit" area="solve">=</calc-btn>
        </form>
    </div>
</template>

<script>
import CalcBtn from '@/components/CalcBtn.vue';

export default {
	name: 'Calculator',
	components: {
		CalcBtn
	},
	data() {
        return {
            entry: '',
            problem: [],
            answer: 0,
            onOp: false,
            onDec: false,
			onPow: false,
			onAns: false
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
			this.onAns = false;
		},
		ce() {
			// Clear entry button
			if (this.onAns) {
				this.clear();
				return;
			}
			this.onDec = false;
			if (!isNaN(this.problem[this.problem.length - 1])) {
				this.problem.pop();
			}
			this.onOp = true;
			this.entry = '';
			this.answer = 0;
		},
		num(char) {
			// Number button
			this.carryAnswer();
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
			if (this.onAns) {
				this.clear();
			}
			this.onDec = true;
			if (!this.entry) {
				this.answer = '0.';
			} else {
				this.answer = this.addCommas(String(this.entry) + '.');
			}
		},
		op(char) {
            // Add, subtract, multiply, or divide button
			this.carryAnswer();
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
			this.carryAnswer(true);
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
			this.carryAnswer(true);
			if (this.entry) {
				this.entry = Math.sqrt(this.entry);
				this.answer = this.addCommas(this.entry);
			}
		},
		sqr() {
            // Square button
			this.carryAnswer(true);
			if (this.entry) {
				this.entry = Math.pow(this.entry, 2);
				this.answer = this.addCommas(this.entry);
			}
		},
		pow() {
            // Caret/power button
			this.carryAnswer(true);
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
			this.carryAnswer(true);
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
			nStr = nStr.toString();
			var x = nStr.split('.');
			var x1 = x[0];
			var x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		},
		carryAnswer(toEntry) {
			// Carry answer over to next equation
			if (this.onAns) {
				if (toEntry) {
					var answer = this.answer;
					this.clear();
					this.entry = answer;
				} else {
					this.problem = [this.answer];
				}
				this.onAns = false;
			}
		},
		solve() {
			// Solve entered equation
			if (this.onAns) return;
			this.powSolve();
			if (this.onOp && this.entry === '') {
				this.entry = 0;
			}
			this.onOp = false;
			this.onDec = false;
			this.problem.push(this.entry);
			this.entry = '';
			try {
				var equation = this.problem.join(' ');
				var answer = equation ? eval(equation) : 0;
				this.answer = this.addCommas(answer);
				this.problem.push('=');
				this.onAns = true;
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
                case '0': this.num('0'); break;
                case '1': this.num('1'); break;
                case '2': this.num('2'); break;
                case '3': this.num('3'); break;
                case '4': this.num('4'); break;
                case '5': this.num('5'); break;
                case '6': this.num('6'); break;
                case '7': this.num('7'); break;
                case '8': this.num('8'); break;
                case '9': this.num('9'); break;
                case '.': this.dec(); break;
                case '`': this.sign(); break;
                case '%': this.per(); break;
                case 'Delete': this.ce(); break;
                case 'Escape': this.clear(); break;
                case 'Backspace': this.back(); break;
                case 'R': this.sqrt(); break;
                case 'S': this.sqr(); break;
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
	--bd-filter: blur(3px);
	display: grid;
	grid-template-rows: auto minmax(0, 1fr);
	grid-template-columns: 1fr;
    font-size: calc(var(--gap) * 2);
	max-width: 640px;
	max-height: 100vh;
	padding: 0;
	padding-left: env(safe-area-inset-left);
	padding-right: env(safe-area-inset-right);
	&__display {
		font-size: 1.6em;
        display: block;
		padding: var(--gap);
		text-align: right;
		color: white;
		background-color: #111111e0;
		backdrop-filter: var(--bd-filter);
	}
	&__problem {
		font-size: 0.6em;
		line-height: 1em;
		padding: var(--gap);
		min-height: calc(1em + (var(--gap) * 2)); /* Line height plus padding */
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
		grid-template-rows: repeat(4, 25%);
		grid-template-columns: repeat(6, 1fr);
		grid-template-areas: 
			"n7 n8 n9 ce c back"
			"n4 n5 n6 pow div sub"
			"n1 n2 n3 sqr mul add"
			"sign n0 dec sqrt per solve";
		backdrop-filter: var(--bd-filter);
    }
}

@media (min-height: 420px) {
	/* Portrait button layout */
	.calculator {
		max-width: 420px;
		&__buttons {
			grid-template-rows: repeat(6, 16.6666%);
			grid-template-columns: repeat(4, 1fr);
			grid-template-areas: 
				"per ce c back"
				"sqrt sqr pow div"
				"n7 n8 n9 mul"
				"n4 n5 n6 sub"
				"n1 n2 n3 add"
				"sign n0 dec solve";
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