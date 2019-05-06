import Vue from 'vue'
import Vuetify from 'vuetify'

Vue.use(Vuetify)


import 'vuetify/dist/vuetify.min.css'

new Vue({
    el: '#app',
    data() {
        return {
            selected: [2],
            items: [{
                action: '18hr',
                headline: 'Recipe to try',
                title: 'Britta Holt',
                subtitle: 'We should eat this: Grate, Squash, Corn, and tomatillo Tacos.'
            }]
            // [{
            //     action: '18hr',
            //     headline: 'Recipe to try',
            //     title: 'Britta Holt',
            //     subtitle: 'We should eat this: Grate, Squash, Corn, and tomatillo Tacos.'
            // }]
        }
    },

    methods: {
        toggle(index) {
            const i = this.selected.indexOf(index)

            if (i > -1) {
                this.selected.splice(i, 1)
            } else {
                this.selected.push(index)
            }
        }
    }
})
