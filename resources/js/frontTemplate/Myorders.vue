<template>
    <Layout>
        <template v-slot:content="slotProps">
            <!-- main-area -->
            <main>
                <section class="breadcrumb-area breadcrumb-bg" data-background="img/bg/breadcrumb_bg03.jpg">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="breadcrumb-content">
                                    <h2>Order Page</h2>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Order</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- breadcrumb-area-end -->

                <!-- cart-area -->
                <div class="cart-area pt-100 pb-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="cart-wrapper">
                                    <!-- Loading state -->
                                    <div v-if="loading" class="text-center">
                                        <p>Loading orders...</p>
                                    </div>

                                    <!-- No orders message -->
                                    <div v-else-if="!loading && (!order || order.length === 0)" class="text-center">
                                        <p>No orders found.</p>
                                    </div>

                                    <!-- Orders table -->
                                    <div v-else class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="product-name">Order Id</th>
                                                    <th class="product-price">Address</th>
                                                    <th class="product-quantity">Payment Method</th>
                                                    <th class="product-subtotal">Cart Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in order" :key="item.id">
                                                    <td class="product-name">
                                                        <router-link :to="'/myOrdersDetails/' + item.id">
                                                            <h4>{{ item.id }}</h4>
                                                        </router-link>
                                                    </td>
                                                    <td class="product-price">
                                                        <span v-if="item.address">
                                                            {{ item.address.address }}
                                                            {{ item.address.city }}
                                                            {{ item.address.pincode }}
                                                            {{ item.address.state }}
                                                        </span>
                                                        <span v-else>No address found</span>
                                                    </td>
                                                    <td class="product-price">{{ item.payment_method }}</td>
                                                    <td class="product-price">{{ item.total_value }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- main-area-end -->
        </template>
    </Layout>
</template>

<script>
import Layout from './Layout.vue'
import axios from 'axios';
import getUrlList from '../provider.js';

export default {
    name: 'Myorders',
    components: {
        Layout
    },
    data() {
        return {
            loading: true,
            token: false,
            order: [],
            user_info: {
                'user_id': '',
                'auth': false
            },
        }
    },
    async mounted() {
        try {
            await this.getUser();
            await this.getMyOrders();
        } catch (error) {
            console.error('Error during component initialization:', error);
            this.loading = false;
        }
    },
    methods: {
        async getMyOrders() {
            try {
                this.loading = true;

                // Make sure we have user info before making the request
                if (!this.user_info.user_id) {
                    console.error('No user ID available');
                    this.loading = false;
                    return;
                }

                const response = await axios.post(getUrlList().getMyOrders, {
                    'token': this.user_info.user_id,
                    'auth': this.user_info.auth
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.user_info.user_id}`,
                        'Content-Type': 'application/json'
                    }
                });

                console.log('Orders response:', response);

                if (response.status === 200) {
                    // Handle different possible response structures
                    let ordersData;
                    if (response.data.data && response.data.data.data) {
                        ordersData = response.data.data.data;
                    } else if (response.data.data) {
                        ordersData = response.data.data;
                    } else if (response.data) {
                        ordersData = response.data;
                    }

                    if (ordersData && Array.isArray(ordersData) && ordersData.length > 0) {
                        this.order = ordersData;
                        console.log('Orders loaded:', this.order);
                    } else {
                        console.log('No orders found in response');
                        this.order = [];
                    }
                } else {
                    console.error('Unexpected response status:', response.status);
                }

            } catch (error) {
                console.error('Error fetching orders:', error);
                if (error.response) {
                    console.error('Error response:', error.response.data);
                }
            } finally {
                this.loading = false;
            }
        },

        async getUser() {
            try {
                if (localStorage.getItem('user_info')) {
                    const user = localStorage.getItem('user_info');
                    const testUser = JSON.parse(user);
                    this.user_info.user_id = testUser.user_id;
                    this.user_info.auth = testUser.auth || false;
                    console.log('User info from localStorage:', this.user_info);
                }
                await this.getUserData();
            } catch (error) {
                console.error('Error getting user info:', error);
            }
        },

        async getUserData() {
            try {
                const response = await axios.post(getUrlList().getUserData, {
                    'token': this.user_info.user_id,
                }, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                console.log('User data response:', response);

                if (response.status === 200 && response.data.data && response.data.data.data) {
                    const userData = response.data.data.data;
                    this.user_info.auth = userData.user_type === 1;
                    this.user_info.user_id = userData.token;
                    localStorage.setItem('user_info', JSON.stringify(this.user_info));
                    console.log('Updated user info:', this.user_info);
                } else {
                    console.log('User data not found or invalid response structure');
                }
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },

        async updateUser(user) {
            this.user_info.auth = true;
            this.user_info.user_id = user;
            localStorage.setItem('user_info', JSON.stringify(this.user_info));
        },
    }
}
</script>