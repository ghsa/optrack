<template>
    <div v-if="calculated">
        <div class="row">
            <div class="col-sm-4">
                <div class="title">Valor Atual</div>
                <div class="big-value">R$ {{ stock.current_price }}</div>
            </div>
            <div class="col-sm-4">
                <div class="title">Strike</div>
                <div class="big-value">
                    R$ {{ option.strike }} ({{
                        (
                            ((option.strike - stock.current_price) /
                                stock.current_price) *
                            100
                        ).toFixed(2)
                    }}%)
                </div>
            </div>
            <div class="col-sm-4">
                <div class="title">Premium</div>
                <div class="big-value">
                    R$ {{ option.price }} ({{
                        ((option.price / stock.current_price) * 100).toFixed(2)
                    }}%)
                </div>
            </div>
        </div>
        <div class="box mt-4">
            <div class="row">
                <div class="col-sm-4">
                    <div class="title">Aumento de 10%</div>
                    <div class="big-value">
                        R$
                        {{ (stock.current_price * 1.1).toFixed(2) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Recompra com 5 dias</div>
                    <div class="big-value">
                        R$
                        {{ recompra10.call.premium.toFixed(2) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Prejuizo</div>
                    <div class="big-value">
                        R$
                        {{
                            (option.price - recompra10.call.premium).toFixed(2)
                        }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Aumento de 15%</div>
                    <div class="big-value">
                        R$
                        {{ (stock.current_price * 1.15).toFixed(2) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Rolagem 28 Dias +15%</div>
                    <div class="big-value">
                        R$
                        {{ rolagem15.call.premium.toFixed(2) }}
                        <span style="font-size: 12px">{{
                            rolagem15.call.delta.toFixed(2)
                        }}</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Saldo</div>
                    <div class="big-value">
                        R$
                        {{
                            (
                                rolagem15.call.premium -
                                (recompra10.call.premium - option.price)
                            ).toFixed(2)
                        }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 20% de aumento -->
        <div class="box mt-4">
            <div class="row">
                <div class="col-sm-4">
                    <div class="title">Aumento de 20%</div>
                    <div class="big-value">
                        R$
                        {{ (stock.current_price * 1.2).toFixed(2) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Recompra com 5 dias</div>
                    <div class="big-value">
                        R$
                        {{ recompra20.call.premium.toFixed(2) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Prejuizo</div>
                    <div class="big-value">
                        R$
                        {{
                            (option.price - recompra20.call.premium).toFixed(2)
                        }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Aumento de 25%</div>
                    <div class="big-value">
                        R$
                        {{ (stock.current_price * 1.25).toFixed(2) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Rolagem 28 Dias +25%</div>
                    <div class="big-value">
                        R$
                        {{ rolagem25.call.premium.toFixed(2) }}
                        <span style="font-size: 12px">{{
                            rolagem25.call.delta.toFixed(2)
                        }}</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title">Saldo</div>
                    <div class="big-value">
                        R$
                        {{
                            (
                                rolagem25.call.premium -
                                (recompra20.call.premium - option.price)
                            ).toFixed(2)
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style >
.box {
    background: #f5f5f5;
    padding: 10px;
    border-radius: 5px;
}
.title {
    font-size: 14px;
    color: #444;
}
.big-value {
    font-size: 22px;
}
</style>

<script>
import bscalc from "../bscalc";
import moment from "moment";
import axios from "axios";

export default {
    props: ["option", "stock", "premium"],
    data() {
        return {
            days: 5,
            time: 0.003968,
            recompra10: null,
            recompra20: null,
            rolagem15: null,
            rolagem25: null,
            calculated: false,
        };
    },
    mounted() {
        this.calculate();
        if (this.premium) {
            this.option.price = this.premium;
        }
    },
    watch: {
        option(newValue, oldValue) {
            this.calculate();
        },
    },
    methods: {
        calculate() {
            const data = {
                spot: this.option.spot_price,
                strike: this.option.strike,
                interest: 2.0,
                expiration: this.time * this.days,
                volatility: this.stock.current_iv,
            };

            // Simulação de 5 dias para o strike aumento de 10%
            data.expiration = this.time * 5;
            data.spot = this.stock.current_price * 1.1;
            this.recompra10 = bscalc(data);

            // Simulação de 5 dias para o strike aumento de 20%
            data.spot = this.stock.current_price * 1.2;
            this.recompra20 = bscalc(data);

            // Simulação de rolagem com 28 dias e 15%
            data.expiration = this.time * 28;
            data.strike = this.stock.current_price * 1.15;
            data.spot = this.stock.current_price * 1.1;
            this.rolagem15 = bscalc(data);

            // Simulação de rolagem com 28 dias e 25%
            data.expiration = this.time * 28;
            data.strike = this.stock.current_price * 1.25;
            data.spot = this.stock.current_price * 1.2;
            this.rolagem25 = bscalc(data);

            this.calculated = true;
        },
    },
};
</script>
