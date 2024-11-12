<template>
    <div :class="colClass?colClass:'col-12'">
        <el-input v-model="wsPhone">
            <template slot="prepend">+51</template>
            <template slot="append">
                <el-tooltip class="item"
                    content="Requiere configuración de tokens en módulo de empresa"
                    effect="dark"
                    placement="top-start">
                    <el-button
                        @click="sendQrChat"
                        :disabled="button_disable"
                        :loading="loading_submit">
                        Enviar <i class="fab fa-whatsapp"></i>
                    </el-button>
                </el-tooltip>
            </template>
        </el-input>
        <small v-if="errors.customer_telephone"
            class="form-control-feedback"
            v-text="errors.customer_telephone[0]"></small>
    </div>
</template>

<script>
import {mapState} from "vuex/dist/vuex.mjs";

export default {
    props: ['colClass','wsPhone','wsFile','wsDocument','wsMessage'],
    data() {
        return {
            form: {},
            errors: {},
            button_disable: true,
            loading_submit: false,
            // text: 'Su comprobante de pago electrónico F001-4 ha sido generado correctamente',
        }
    },
    computed: {
        ...mapState([
            'config',
        ]),
    },
    created() {
        this.enableSend()
    },
    methods: {
        enableSend() {
            if(this.config.qrchat_url != '' && this.config.qrchat_app_key != '' && this.config.qrchat_auth_key != '') {
                this.button_disable = false
            }
        },
        sendQrChat() {
            this.loading_submit = true
            if (this.wsPhone == '') {
                return this.$message.error('El número es obligatorio')
            }
            this.setForm()
            this.$http
                .post(this.config.qrchat_url, this.form)
                .then(response => {
                    if(response.data.data.status_code == 200) {
                        return this.$message.success('Documento enviado con exito')
                    }
                })
                .catch(error => {
                    console.log(error)
                    return this.$message.error('No se puede enviar')
                })
                .finally(() => {
                    this.loading_submit = false
                });
        },
        setForm() {
            this.form = {
                appkey: this.config.qrchat_app_key,
                authkey: this.config.qrchat_auth_key,
                to: `51${this.wsPhone}`,
                message: this.wsMessage,
                file: this.wsFile
            }
        }
    }
}

</script>