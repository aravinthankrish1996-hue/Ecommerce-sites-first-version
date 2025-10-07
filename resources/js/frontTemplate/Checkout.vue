<template>
    <Layout>
        <template v-slot:content="slotProps">

            <!-- main-area -->
            <main>

                <!-- breadcrumb-area -->
                <section class="breadcrumb-area breadcrumb-bg" data-background="img/bg/breadcrumb_bg03.jpg">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="breadcrumb-content">
                                    <h2>Checkout Page</h2>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- breadcrumb-area-end -->

                <!-- checkout-area -->
                <section class="checkout-area pt-95 pb-95">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="checkout-wrap">
                                    <div class="checkout-top">
                                        <h5 class="title">Billing details</h5>
                                        <a href="cart.html" class="back"><i class="fas fa-angle-left"></i> -- Back to
                                            Cart</a>
                                    </div>
                                    <form action="#" class="checkout-form">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-grp">
                                                    <label for="fName">FIRST NAME <span>*</span></label>
                                                    <input type="text" id="fName" v-model="firstName">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-grp">
                                                    <label for="lName">Last NAME <span>*</span></label>
                                                    <input type="text" id="lName" v-model="lastName">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-grp">
                                                    <label for="phone">Your PHONE <span>*</span></label>
                                                    <input type="text" id="phone" v-model="phone">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-grp">
                                                    <label for="email">EMAIL ADDRESS <span>*</span></label>
                                                    <input type="email" id="email" v-model="email">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-grp">
                                                    <label>COUNTRY / REGION <span>*</span></label>
                                                    <input type="text" id="cName" v-model="country">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-grp">
                                                    <label for="zip">Pincode <span>*</span></label>
                                                    <input type="number" id="zip" @blur="getPincodeDetails()"
                                                        v-model.number="pincode">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-grp">
                                                    <label for="address">STREET ADDRESS <span>*</span></label>
                                                    <input type="text" id="address" v-model="address">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-grp">
                                                    <label>TOWN / CITY <span>*</span></label>
                                                    <input type="text" id="zip" v-model="city" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-grp">
                                                    <label>STATE <span>*</span></label>
                                                    <input type="text" id="zip" v-model="state" readonly>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="different-address custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="stda">
                                                    <label class="custom-control-label" for="stda">SHIP TO A DIFFERENT
                                                        ADDRESS?</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-grp mb-0">
                                                    <label for="message">ORDER you have NOTES
                                                        <small>(OPTIONAL)</small></label>
                                                    <textarea name="message" id="message"
                                                        placeholder="About Your Special Delivery Notes"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-8">
                                <aside class="checkout-sidebar">
                                    <h6 class="title">Cart Totals</h6>
                                    <div class="shop-cart-widget">
                                        <form action="#">
                                            <ul>
                                                <li class="sub-total"><span>SUBTOTAL</span> Rs {{ slotProps.cartTotal }}
                                                </li>
                                                <li class="sub-total"><span>Coupon</span> {{ slotProps.couponName }}
                                                </li>
                                                <li>
                                                    <span>SHIPPING</span>
                                                    <div class="shop-check-wrap">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck1">
                                                            <label class="custom-control-label" for="customCheck1">FLAT
                                                                RATE: $15</label>
                                                        </div>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="customCheck2">
                                                            <label class="custom-control-label" for="customCheck2">FREE
                                                                SHIPPING</label>
                                                        </div>
                                                        <a href="#" class="calculate">Calculate shipping</a>
                                                    </div>
                                                </li>
                                                <li class="cart-total-amount"><span>TOTAL</span> <span class="amount">Rs
                                                        {{ slotProps.cartTotal }}</span></li>
                                            </ul>
                                            <div class="payment-method-info">
                                                <div class="paypal-method-flex">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="radio" v-model="paymentMethod" value="cod"
                                                            class="custom-control-input" id="customCheck5">
                                                        <label class="custom-control-label" for="customCheck5">Cash on
                                                            delivery</label>
                                                        <p>Pay with cash upon delivery.</p>
                                                    </div>
                                                </div>
                                                <div class="paypal-method-flex">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="radio" checked v-model="paymentMethod"
                                                            value="online" class="custom-control-input"
                                                            id="customCheck6">
                                                        <label class="custom-control-label" for="customCheck6">Payments
                                                            on Online</label>
                                                    </div>
                                                    <div class="paypal-logo"><img src="img/images/card.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="payment-terms">
                                                <p>The purpose Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                                    sed do eiusmod tempor incididunt ut labore et
                                                    dolore</p>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customCheck7">
                                                    <label class="custom-control-label" for="customCheck7">I have read
                                                        and agree to the website terms and conditions</label>
                                                </div>
                                            </div>
                                            <button type="button" class="btn" @click="placeOrder()">Place order</button>
                                        </form>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- checkout-area-end -->

            </main>
            <!-- main-area-end -->

        </template>
    </Layout>
</template>

<script>
import Layout from './Layout.vue'
import axios from 'axios';
import getUrlList from '../provider.js';
// import { parse } from 'vue/compiler-sfc';

export default {
    name: 'Checkout',
    components: {
        Layout
    },
    data() {
        return {
            token: false,
            user_info: {
                'user_id': '',
                'auth': false
            },
            userDetails: {},
            firstName: 'Aravind',
            lastName: 'krishnan',
            email: 'Aravind' + Math.floor(Math.random() * 10000) + '@gmail.com',
            address: '123',
            country: 'INDIA',
            city: 'jalandhar',
            state: 'punjab',
            pincode: '144008',
            phone: '9443221858',
            paymentMethod: 'online',

        }
    },
    mounted() {
        this.getUser();
    },
    methods: {
        async placeOrder() {
            if (!this.pincode || !this.firstName || !this.lastName || !this.email || !this.address || !this.phone) {
                alert('All required fields must be filled out.');
                return;
            }

            try {
                // --- First API Call: Place the order ---
                let placementResult = await axios.post(getUrlList().placeOrder, {
                    'token': this.user_info.user_id,
                    'auth': this.user_info.auth,
                    'firstName': this.firstName,
                    'lastName': this.lastName,
                    'email': this.email,
                    'address': this.address,
                    'country': this.country,
                    'city': this.city,
                    'state': this.state,
                    'pincode': this.pincode,
                    'phone': this.phone,
                    'paymentMethod': this.paymentMethod,
                });

                if (placementResult.status === 200 && placementResult.data.data) {
                    const responseData = placementResult.data.data.data[0];
                    const newToken = responseData.user;
                    const newOrderId = responseData.order;

                    if (!newToken) {
                        alert("Critical Error: No authentication token received from server.");
                        return;
                    }

                    this.updateUser(newToken);

                    // --- Handle Online Payment ---
                    if (this.paymentMethod === 'online') {
                        console.log("Order placed successfully. Redirecting to payment gateway...");

                        // --- Second API Call: Get the payment URL ---
                        let paymentResult = await axios.post(
                            getUrlList().makePaymentOnline,
                            {
                              
                                'order_id': newOrderId,
                            },
                            {
                                headers: {
                                   
                                    'Authorization': `Bearer ${newToken}`
                                }
                            }
                        );

                    
                        if (paymentResult.data && paymentResult.data.payment_url) {
                            window.location.href = paymentResult.data.payment_url;
                        } else {
                            alert("Could not get the payment redirection link. Please try again.");
                        }

                    } else {
                        // Handle Cash on Delivery
                        alert("Your order has been placed successfully!");
                        // this.$router.push({ name: 'order-success' }); // Example redirect
                    }
                } else {
                    alert('Could not place your order. Please try again.');
                }

            } catch (error) {
                console.error("An API error occurred:", error);
                if (error.response) {
                    alert(`Error: ${error.response.data.message || 'Something went wrong.'}`);
                } else {
                    alert('A network error occurred. Please check your connection.');
                }
            }
        },
        // ... your other methods (updateUser, getPincodeDetails, etc.)
        async updateUser(user) {
            this.user_info.auth = true;
            this.user_info.user_id = user;
            localStorage.setItem('user_info', JSON.stringify(this.user_info));
        },
        async getPincodeDetails() {
            if (this.pincode !== '') {
                try {
                    let data = await axios.post(getUrlList().getPincodeDetails,
                        {
                            'token': this.user_info.user_id,
                            'auth': this.user_info.auth,
                            'pincode': this.pincode,

                        });
                    var result = data;
                    if (result.data == 200) {
                        this.city = data.data.data.data.City;
                        this.state = data.data.data.data.State;
                    } else {
                        console.log('Rec not found');
                    }
                } catch (error) {
                    alert(error.response.data.message);
                }

            }
        },
        async getUser() {
            if (localStorage.getItem('user_info')) {
                var user = localStorage.getItem('user_info');
                var testUser = JSON.parse(user);
                this.user_info.user_id = testUser.user_id;
                this.getUserData();
            } else {
                this.getUserData();
            }
        },
        async getUserData() {
            try {
                let data = await axios.post(getUrlList().getUserData,
                    {
                        'token': this.user_info.user_id,
                    });
                if (data.status == 200) {
                    if (data.data.data.data.user_type == 1) {
                        this.user_info.auth = true;
                        this.user_info.user_id = data.data.data.data.token;
                        localStorage.setItem('user_info', JSON.stringify(this.user_info));

                    } else {
                        this.user_info.auth = false;
                        this.user_info.user_id = data.data.data.data.token;
                        localStorage.setItem('user_info', JSON.stringify(this.user_info));
                    }
                } else {
                    console.log('Data Not Found');
                }
            } catch (error) {

            }

        },

    }
}

</script>
