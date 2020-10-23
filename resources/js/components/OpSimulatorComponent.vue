<template>
    <div>Simulador</div>
</template>

<script>
import bscalc from "../bscalc";
import moment from "moment";
import axios from "axios";

export default {
    props: ["option"],
    mounted() {},
    methods: {
        load() {
            console.log("Loading");
        },
        loadOption() {
            console.log("Carregando Opção");
        },
    },
};
</script>
