<template>
    <div>
        <table class="table table-dashed table-hover">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Strike</th>
                    <th>Diferença</th>
                    <th>Valor</th>
                    <th>Ganho</th>
                    <th>Dias</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="option in options" :key="option.id">
                    <td>
                        <a
                            :href="'/userOption/create?option_id=' + option.id"
                            class="btn btn-success btn-sm"
                            >Vender</a
                        >
                    </td>
                    <td>{{ option.type }}</td>
                    <td>{{ option.name }}</td>
                    <td>R$ {{ option.strike }}</td>
                    <td>
                        {{
                            (
                                ((option.strike - stock.current_price) /
                                    stock.current_price) *
                                100
                            ).toFixed(2)
                        }}%
                    </td>
                    <td>
                        <b>R$ {{ option.price }}</b>
                    </td>
                    <td>
                        {{ ((option.price / option.strike) * 100).toFixed(2) }}%
                    </td>
                    <td>{{ option.days_to_maturity }}</td>
                    <td>
                        <button
                            class="btn btn-sm btn-primary"
                            @click="selectOption(option)"
                        >
                            Detalhes
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div
            class="modal fade"
            id="op-simulator"
            tabindex="-1"
            role="dialog"
            aria-labelledby="op-simulatorLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" v-if="option">
                    <div class="modal-header">
                        {{ option.name }}
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <op-simulator :option="option" :stock="stock" />
                    </div>
                    <div class="modal-footer">
                        <button
                            @click="close"
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Fechar
                        </button>
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
    props: ["options", "stock"],
    data() {
        return {
            option: null,
            days: 5,
            time: 0.003968,
            recompra10: null,
            recompra20: null,
            rolagem15: null,
            rolagem25: null,
        };
    },
    mounted() {
        console.log(this.stock);
        console.log(this.options);
    },
    methods: {
        selectOption(option) {
            this.option = option;
            $("#op-simulator").modal("show");
            //this.calculate();
        },
        close() {
            $("#op-simulator").modal("hide");
        },
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
            console.log(this.recompra10.call.premium);

            // Simulação de 5 dias para o strike aumento de 20%
            data.spot = this.stock.current_price * 1.2;
            this.recompra20 = bscalc(data);
            console.log("20%", this.recompra20.call.premium);

            // Simulação de rolagem com 28 dias e 15%
            data.expiration = this.time * 28;
            data.strike = this.stock.current_price * 1.15;
            data.spot = this.stock.current_price * 1.1;
            this.rolagem15 = bscalc(data);
            console.log(this.rolagem15.call.premium);

            // Simulação de rolagem com 28 dias e 25%
            data.expiration = this.time * 28;
            data.strike = this.stock.current_price * 1.25;
            data.spot = this.stock.current_price * 1.2;
            this.rolagem25 = bscalc(data);
            console.log(this.rolagem25.call.premium);
        },
    },
};
</script>
