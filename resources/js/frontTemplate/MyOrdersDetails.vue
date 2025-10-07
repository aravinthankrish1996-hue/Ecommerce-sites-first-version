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
                                <div v-if="loading" class="text-center">
                                    <p>Loading order details...</p>
                                </div>

                                <div v-else-if="order && order_details.length > 0" class="cart-wrapper">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="product-thumbnail"></th>
                                                    <th class="product-name">Product</th>
                                                    <th class="product-price">Price</th>
                                                    <th class="product-quantity">QUANTITY</th>
                                                    <th class="product-subtotal">SUBTOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in order_details" :key="item.id">
                                                    <td class="product-thumbnail">

                                                        <a href="#" v-if="item.product_attr && item.product_attr.products && Array.isArray(item.product_attr.products) && item.product_attr.products.length > 0 && item.product_attr.products[0].image_url">
                                                            <img :src="item.product_attr.products[0].image_url"
                                                                alt="Product Image"
                                                                style="width: 80px; height: 80px; object-fit: cover;">
                                                        </a>

                                                        <div v-else class="no-image-placeholder"
                                                            style="width: 80px; height: 80px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd;">
                                                            <span style="font-size: 12px; color: #999;">No Image</span>
                                                        </div>
                                                    </td>
                                                    <td class="product-name">
                                                        <h4
                                                            v-if="item.product_attr && item.product_attr.products && Array.isArray(item.product_attr.products) && item.product_attr.products.length > 0 && item.product_attr.products[0].name">
                                                            {{ item.product_attr.products[0].name }}
                                                        </h4>
                                                        <h4 v-else style="color: #999;">Product Not Available</h4>
                                                    </td>
                                                    <td class="product-price">
                                                        Rs {{ item.product_attr ? item.product_attr.price : '0.00' }}
                                                    </td>
                                                    <td class="product-quantity">
                                                        <div class="cart-plus-minus">
                                                            <form action="#" class="num-block">
                                                                <input type="text" class="in-num" :value="item.qty"
                                                                    readonly>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td class="product-subtotal">
                                                        <span>Rs {{ parseFloat(item.total_value).toFixed(2) }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div v-else class="text-center">
                                    <p>{{ errorMessage || 'No order details found.' }}</p>
                                </div>

                                <div v-if="order" class="cart-total pt-95">
                                    <h3 class="title">ORDER SUMMARY</h3>
                                    <div class="shop-cart-widget">
                                        <form action="#">
                                            <ul>
                                                <li class="sub-total">
                                                    <span>SUBTOTAL</span> Rs {{ parseFloat(order.total_value).toFixed(2)
                                                    }}
                                                </li>
                                                    <li>
                                                    <span>COUPON</span>
                                                    <div class="shop-check-wrap">
                                                        <span class="calculate">{{ order.coupon ||
                                                            'Not specified' }}</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>SHIPPING</span>
                                                    <div class="shop-check-wrap">
                                                        <span class="calculate">{{ order.shipping_service ||
                                                            'Not specified' }}</span>
                                                    </div>
                                                </li>
                                                <li class="cart-total-amount">
                                                    <span>Payment Method</span>
                                                    <span class="amount">{{ order.payment_method || 'Not specified'
                                                        }}</span>
                                                </li>
                                                <li class="cart-total-amount">
                                                    <span>TOTAL</span>
                                                    <span class="amount">Rs {{ parseFloat(order.total_value).toFixed(2)
                                                        }}</span>
                                                </li>
                                            </ul>
                                        </form>
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
    name: 'MyOrdersDetails',
    components: {
        Layout
    },
    data() {
        return {
            loading: false,
            errorMessage: '',
            order: null,
            order_details: [],
            order_id: '',
            user_info: {
                'user_id': '',
                'auth': false
            },
        }
    },
    async mounted() {
        await this.getUser();
        await this.getMyOrdersDetails();
    },
    methods: {
        async getMyOrdersDetails() {
            try {
                this.loading = true;
                this.errorMessage = '';
                this.order_id = this.$route.params.order_id;

                if (!this.order_id) {
                    this.errorMessage = 'Order ID is required';
                    return;
                }

                if (!this.user_info.user_id) {
                    this.errorMessage = 'User authentication required';
                    return;
                }

                const response = await axios.post(getUrlList().MyOrdersDetails, {
                    'token': this.user_info.user_id,
                    'auth': this.user_info.auth,
                    'order_id': this.order_id
                }, {
                    headers: {
                        'Authorization': `Bearer ${this.user_info.user_id}`,
                        'Content-Type': 'application/json'
                    }
                });

                console.log('API Response:', response.data);

                if (response.status === 200 && response.data.data && response.data.data.data && response.data.data.data.length > 0) {
                    const orderData = response.data.data.data[0];
                    this.order = orderData;
                    this.order_details = orderData.order_details || [];

                    console.log('Order:', this.order);
                    console.log('Order Details:', this.order_details);
                } else {
                    this.errorMessage = 'No order data found';
                    console.log('No Data Found or Invalid Response Structure');
                }

            } catch (error) {
                console.error('API Error:', error);
                this.errorMessage = 'Failed to load order details. Please try again.';

                if (error.response) {
                    console.log('Error Response:', error.response.data);
                    console.log('Error Status:', error.response.status);
                }
            } finally {
                this.loading = false;
            }
        },

        async getUser() {
            try {
                const storedUser = localStorage.getItem('user_info');
                if (storedUser) {
                    const parsedUser = JSON.parse(storedUser);
                    this.user_info.user_id = parsedUser.user_id;
                    this.user_info.auth = parsedUser.auth;
                }

                await this.getUserData();
            } catch (error) {
                console.error('Error getting user:', error);
            }
        },

        async getUserData() {
            try {
                if (!this.user_info.user_id) {
                    console.log('No user ID found');
                    return;
                }

                const response = await axios.post(getUrlList().getUserData, {
                    'token': this.user_info.user_id,
                });

                if (response.status === 200 && response.data.data && response.data.data.data) {
                    const userData = response.data.data.data;
                    this.user_info.auth = userData.user_type === 1;
                    this.user_info.user_id = userData.token;
                    localStorage.setItem('user_info', JSON.stringify(this.user_info));
                } else {
                    console.log('User Data Not Found');
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