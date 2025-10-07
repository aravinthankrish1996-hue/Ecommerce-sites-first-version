<template>
    <Layout>
        <template v-slot:content="slotProps">

            <main>

                <div class="breadcrumb-area breadcrumb-style-two" data-background="img/bg/s_breadcrumb_bg01.jpg">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 d-none d-lg-block">
                                <div class="previous-product">
                                    <a href="shop-details.html"><i class="fas fa-angle-left"></i> Transaction</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="shop-area pt-100 pb-100">
                    <div class="container">
                        <div class="row">
                            <ul>
                                <li>
                                    <h2>Your Payment has been {{ status }}</h2>
                                    <h2>Transaction Id: {{ transaction_id }}</h2>
                                    <li><h2><router-link to="/myorders">Go to orders</router-link></h2></li>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </main>
        </template>
    </Layout>
</template>

<script>
import Layout from './Layout.vue'
// Note: axios and getUrlList are imported but not used in the provided script.
// import axios from 'axios';
// import getUrlList from '../provider.js';

export default {
    name: 'ShowPaymentThankyou',
    components: {
        Layout
    },
    data() {
        return {
            status: '',
            transaction_id: ''
        }
    },
    mounted() {
        this.getTransaction();
    },
    methods: {
        getTransaction() {
            this.status = this.$route.params.status;
            this.transaction_id = this.$route.params.transaction_id;

            if (!this.status || !this.transaction_id) {
                this.$router.push({ name: 'Index' });
                return;
            }
        }
    }
}
</script>