import axios from "axios";
import EventBus from "../../eventBus";

export default {
    data() {
        return {
            label: ''
        }
    },
    methods: {
        confirmDestroy(id, path, callback) {
            this.$buefy.dialog.confirm({
                message: 'Tem certeza de que deseja remover?',
                onConfirm: () => {
                    axios
                        .delete(`${path}/${id}`)
                        .then((res) => {
                            this.$buefy.notification.open({
                                duration: 5000,
                                message: `${this.label} removido com sucesso!`,
                                type: 'is-success'
                            })
                            callback()
                        })
                }
            })
        },
        alertSubmitedSuccess(isUpdate) {
            this.$buefy.notification.open({
                duration: 5000,
                message: `${this.label} ${isUpdate ? 'atualizado' : 'criado'} com sucesso!`,
                type: 'is-success'
            })
        }
    },
    mounted: function() {
        EventBus.subscribe('validation_error', messages => {
            this.$buefy.notification.open({
                duration: 5000,
                message: messages.join("\n"),
                type: 'is-danger'
            })
        })
    }
}
