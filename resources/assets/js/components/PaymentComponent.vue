<template>
    <div>
        <span class="subtitle">Método de pago</span>
        <div class="field is-grouped">
            <p class="control">
                <button class="button is-large" @click.prevent="isVisa()">
                    <img src="/icons/Visa.svg" alt="Visa">
                </button>
            </p>
            <p class="control">
                <button class="button is-large">
                    <img src="/icons/PayPal.svg" alt="Paypal">
                </button>
            </p>
        </div>
        <div v-if="visa">
            <div class="field">
                <label class="label">Nombre del titular</label>
                <div class="control">
                    <input class="input" :class="{'is-danger': errors.has('nombre')}" type="text" placeholder="Como aparece en la tarjeta" name="nombre" v-validate="'required|alpha_spaces|min:3|max:30'"
                           v-model.trim="nombre">
                    <p v-if="errors.has('nombre')" class="help is-danger">{{ errors.first('nombre') }}</p>
                </div>
            </div>
            <div class="field">
                <label class="label">Número de tarjeta</label>
                <div class="control">
                    <input class="input" :class="{'is-danger': errors.has('numero')}" type="text" name="numero" v-validate="'required|credit_card'"
                           v-model.trim="numero">
                    <p v-if="errors.has('numero')" class="help is-danger">{{ errors.first('numero') }}</p>
                </div>
            </div>
            <!--<input class="input" type="text" id="numero" pattern="[0-9]{16,19}" maxlength="19" placeholder="0000-0000-0000-0000" size="5" v-model.trim="numero">-->
            <div class="details">
                    <div class="select">
                        <select v-model="mes">
                            <option>MM</option>
                            <option value="1">01</option>
                            <option value="2">02</option>
                            <option value="3">03</option>
                            <option value="4">04</option>
                            <option value="5">05</option>
                            <option value="6">06</option>
                            <option value="7">07</option>
                            <option value="8">08</option>
                            <option value="9">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <span style="font-size: x-large">/</span>
                    <div class="select">
                        <select v-model="anio">
                            <option>YYYY</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                    </div>
            </div>
            <div class="field">
                <label class="label">Código de seguridad</label>
                <div class="control">
                    <input class="input" :class="{'is-danger': errors.has('codigo')}" placeholder="3 dígitos" maxlength="3" width="48" type="password" name="codigo" v-validate="'required|digits:3'"
                           v-model.trim="cvc">
                    <p v-if="errors.has('codigo')" class="help is-danger">{{ errors.first('codigo') }}</p>
                </div>
            </div>
            <!--<input class="input" type="text" id="secreto" placeholder="123" maxlength="4" width="48" v-model="cvc">-->
        </div>
    </div>
</template>

<script>
    export default {
        name: "payment-component",
        data() {
            return {
                visa: false,
                nombre: '',
                numero: '',
                mes:'MM',
                anio: 'YYYY',
                cvc: ''
            }
        },
        methods: {
            isVisa() {
               this.visa = this.visa === false;
            },
            getDatosVisa(){
                return {
                    nombre: this.nombre,
                    numero: this.numero,
                    mes: this.mes,
                    anio: this.anio,
                    cvc: this.cvc
                }
            }
        }
    }
</script>

<style scoped>
    .details{
        margin: .5rem 0;
    }
</style>