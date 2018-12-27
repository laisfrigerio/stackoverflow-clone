export default {
    data() {
        return {
            editing: false,
        }
    },

    methods: {
        edit() {
            this.setEditCache();
            this.editing = true;
        },

        cancel() {
            this.restoreFromCache();
            this.editing = false;
        },

        update() {
            axios.put(this.endPoint, this.payload())
                .then(({data}) => {
                    this.editing = false;
                    this.bodyHtml = data.body_html;
                    this.$toast.success(data.message, "Success", { timeout: 3000, position: 'topRight'});
                })
                .catch(({response}) => {
                    this.$toast.error(response.data.message, "Error", { timeout: 3000, position: 'topRight'});
                });
        },

        destroy () {
            this.$toast.question('Are you sure about that?', "Confirm", {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {
                        this.delete();
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }],
                ]
            });
        },

        restoreFromCache() {},
        setEditCache() {},
        payload() {},
        delete() {},
    }
}