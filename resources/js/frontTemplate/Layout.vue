<template>
    <!-- preloader  -->
    <!-- <div id="preloader">
        <div id="ctn-preloader" class="ctn-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
            </div>
            <div class="loader">
                <div class="row">
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- preloader end -->


    <!-- Scroll-top -->
    <button class="scroll-top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button>
    <!-- Scroll-top-end-->

    <!-- header-area -->
    <header class="header-style-two">
        <div id="sticky-header" class="main-header transparent-header menu-area">
            <div class="container custom-container-two">
                <div class="row">
                    <div class="col-12">
                        <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                        <div class="menu-wrap">
                            <nav class="menu-nav show">
                                <div class="logo">
                                    <router-link :to="'/'" class="main-logo"><img src="../assets/img/logo/fw_logo.png"
                                            alt="Logo"></router-link>
                                    <router-link :to="'/'" class="sticky-logo"><img src="../assets/img/logo/logo.png"
                                            alt="Logo"></router-link>
                                </div>
                                <div class="navbar-wrap main-menu d-none d-lg-flex">
                                    <ul class="navigation">
                                        <li v-for="item in headerCategories" :key="item.id" class="has--mega--menu">
                                            <router-link :to="'/category/' + item.slug">{{ item.name }}</router-link>
                                            <ul class="mega-menu">
                                                <li class="mega-menu-wrap">
                                                    <ul class="mega-menu-col">
                                                        <li class="mega-title"><a href="shop.html">{{ item.name }}</a>
                                                        </li>
                                                        <li v-for="subitem in item.subcategories" :key="subitem.id">
                                                            <router-link :to="'/category/' + subitem.slug">{{
                                                                subitem.name
                                                                }}</router-link>
                                                        </li>

                                                    </ul>

                                                    <ul class="mega-menu-col sub-cat-post">
                                                        <li>
                                                            <a href="shop-sidebar.html">
                                                                <img :src="item.image_url" :alt="item.name">
                                                                <span class="btn">{{ item.name }}</span>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="about-us.html">About Us</a></li>

                                        <li><a href="contact.html">Contact Us</a></li>
                                    </ul>
                                </div>
                                <div class="header-action d-none d-md-block">
                                    <ul>
                                        <li class="header-search"><a href="#" data-toggle="modal"
                                                data-target="#search-modal"><i class="flaticon-search"></i></a></li>
                                        <li class="header-shop-cart"><a href="#"><i
                                                    class="flaticon-shopping-bag"></i><span>{{ cartCount }}</span></a>
                                            <ul class="minicart">
                                                <li v-if="cartCount > 0" v-for="item in cartProduct" :key="item.id"
                                                    class="d-flex align-items-start">
                                                    <div class="cart-img">
                                                        <a href="#"><img :src="item.product.image_url" style="height:50px;width: 50px;"  alt=""></a>
                                                    </div>
                                                    <div class="cart-content">
                                                        <h4><a href="#">{{ item.product.name }}</a></h4>
                                                        <div class="cart-price">
                                                            <span class="new">Rs {{ item.attribute.price }}</span>
                                                            <span><del>Rs {{ item.attribute.mrp }}</del></span>
                                                        </div>
                                                    </div>
                                                    <div class="del-icon">
                                                        <a href="javascript:void(0)"
                                                            @click="removeCartData(item.product_id, item.product_attr_id, 1)"><i
                                                                class="far fa-trash-alt"></i></a>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="total-price">
                                                        <span class="f-left">Total:</span>
                                                        <span class="f-right">Rs{{ cartTotal }}</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkout-link">
                                                        <router-link :to="'/ShoppingCart'">Shopping Cart</router-link>
                                                        <a class="black-color" href="#">Checkout</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="header-profile"><a href="#"><i class="flaticon-user-profile"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <!-- Mobile Menu  -->
                        <div class="mobile-menu">
                            <div class="close-btn"><i class="flaticon-targeting-cross"></i></div>
                            <nav class="menu-box">
                                <div class="nav-logo"><a href="index.html"><img src="../assets/img/logo/logo.png" alt=""
                                            title=""></a>
                                </div>
                                <div class="menu-outer">
                                    <ul class="navigation">
                                        <li class="active menu-item-has-children"><a href="#">Home</a>
                                            <ul class="submenu">
                                                <li><a href="index.html">Home One</a></li>
                                                <li><a href="index-2.html">Home Two</a></li>
                                                <li class="active"><a href="index-3.html">Home Three</a></li>
                                                <li><a href="index-4.html">Home Four</a></li>
                                                <li><a href="index-5.html">Home Five</a></li>
                                                <li><a href="index-6.html">Home Six</a></li>
                                                <li><a href="index-7.html">Home Seven</a></li>
                                                <li><a href="index-8.html">Home Eight</a></li>
                                                <li><a href="index-9.html">Home Nine</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children"><a href="#">Shop</a>
                                            <ul class="submenu">
                                                <li><a href="shop.html">Shop Page</a></li>
                                                <li><a href="shop-sidebar.html">Shop Sidebar</a></li>
                                                <li><a href="shop-details.html">Shop Details</a></li>
                                                <li><a href="cart.html">Cart Page</a></li>
                                                <li><a href="cart.html">Checkout Page</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="about-us.html">About Us</a></li>
                                        <li class="menu-item-has-children"><a href="#">blog</a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">Our Blog</a></li>
                                                <li><a href="blog-details.html">Blog Details</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contact.html">Contact Us</a></li>
                                    </ul>
                                </div>
                                <div class="social-links">
                                    <ul class="clearfix">
                                        <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                        <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                        <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                        <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                        <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="menu-backdrop"></div>
                        <!-- End Mobile Menu -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Search -->
        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form>
                        <input type="text" placeholder="Search here...">
                        <button><i class="flaticon-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Search-end -->

        <!-- off-canvas-start -->
        <div class="sidebar-toggle-btn"><a href="#" class="navSidebar-button"><img
                    src="../assets/img/icon/sidebar_toggle_icon.png" alt=""></a></div>
        <div class="sidebar-off-canvas info-group">
            <div class="off-canvas-overlay"></div>
            <div class="off-canvas-widget scroll">
                <div class="sidebar-widget-container">
                    <div class="off-canvas-heading">
                        <a href="#" class="close-side-widget">
                            <span class="flaticon-targeting-cross"></span>
                        </a>
                    </div>
                    <div class="sidebar-textwidget">
                        <div class="sidebar-info-contents">
                            <div class="content-inner">
                                <div class="logo mb-30">
                                    <a href="index.html"><img src="../assets/img/logo/logo.png" alt=""></a>
                                </div>
                                <div class="content-box">
                                    <p>WooCommerce and WordPress are both free, open source software reasons many ...
                                    </p>
                                </div>
                                <div class="contact-info">
                                    <h4 class="title">CONTACT US</h4>
                                    <ul>
                                        <li><span class="flaticon-phone-call"></span><a href="tel:123456789">+9 325 444
                                                0000</a></li>
                                        <li><span class="flaticon-email"></span><a
                                                href="mailto:adara@info.com">adara@info.com</a></li>
                                        <li><span class="flaticon-place"></span>71 Park Lan Street 2355 NY</li>
                                    </ul>
                                </div>
                                <div class="oc-newsletter">
                                    <h4 class="title">NEWSLETTER</h4>
                                    <p>Fill your email below to subscribe to my newsletter</p>
                                    <form action="#">
                                        <input type="email" placeholder="Email...">
                                        <button class="btn">Subscribe</button>
                                    </form>
                                </div>
                                <div class="oc-social">
                                    <ul>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="#"><i class="fab fa-google"></i></a></li>
                                    </ul>
                                </div>
                                <div class="oc-bottom">
                                    <div class="currency">
                                        <form action="#">
                                            <label>Currency</label>
                                            <select name="select">
                                                <option value="">USD</option>
                                                <option value="">AUE</option>
                                                <option value="">SAR</option>
                                                <option value="">INR</option>
                                                <option value="">BDT</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="language">
                                        <form action="#">
                                            <label>Language</label>
                                            <select name="select">
                                                <option value="">English</option>
                                                <option value="">Spanish</option>
                                                <option value="">Turkish</option>
                                                <option value="">Russian</option>
                                                <option value="">Chinese</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- off-canvas-end -->

    </header>
    <!-- header-area-end -->
    <main>
        <slot name="content" :addToCart="addToCart" :cartCount="cartCount" :cartProduct="cartProduct"
            :cartTotal="cartTotal" :removeCartData="removeCartData" :addCoupon="addCoupon" :getCartData="getCartData"
            :removeCoupon="removeCoupon" :couponName="couponName">

        </slot>
    </main>



    <!-- footer-area -->
    <footer class="dark-bg pt-55 pb-80">
        <div class="container">
            <div class="footer-top-wrap">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-logo">
                            <a href="index.html"><img src="../assets/img/logo/w_logo.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-middle-wrap">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-link-wrap">
                            <nav class="menu-links">
                                <ul>
                                    <li><a href="about-us.html">About us</a></li>
                                    <li><a href="shop-sidebar.html">Store</a></li>
                                    <li><a href="contact.html">Locations</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                    <li><a href="contact.html">Support</a></li>
                                    <li><a href="#">Policy</a></li>
                                    <li><a href="#">Faqs</a></li>
                                </ul>
                            </nav>
                            <div class="footer-social">
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-wrap">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="copyright-text">
                            <p>&copy; 2021 <a href="index.html">adara</a>. All Rights Reserved | Ph (+09) 456 457869</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="pay-method-img">
                            <img src="../assets/img/images/payment_method_img.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id="scripts"></div>
</template>
<script>
import axios from 'axios';
import getUrlList from '../provider.js';

export default {
    name: 'Layout',
    data() {
        return {
            headerCategories: [],
            user_info: {
                'user_id': '',
                'auth': false
            },
            cartCount: 0,
            cartProduct: [],
            cartTotal: 0,
            oldCart: 0,
            couponName: '',
            cart_product: ''
        }
    },
    watch: {
        cartProduct(newCartItems) {
            this.cartTotal = 0;
            // Use a for...of loop for arrays
            for (const item of newCartItems) {
                // Ensure item and its properties exist before accessing
                if (item && item.qty && item.attribute && item.attribute.price) {
                    this.cartTotal += item.qty * item.attribute.price;
                }
            }
            this.oldCart = this.cartTotal;
            this.getUserCoupon();
        }
    },
    mounted() {
        // NOTE: Dynamically loading jQuery-dependent scripts like this can sometimes conflict 
        // with Vue's lifecycle. For more complex apps, consider using Vue-specific libraries.
        var src = ['/frontend_assets/js/popper.min.js', '/frontend_assets/js/bootstrap.min.js', '/frontend_assets/js/isotope.pkgd.min.js',
            '/frontend_assets/js/imagesloaded.pkgd.min.js', '/frontend_assets/js/jquery.magnific-popup.min.js', '/frontend_assets/js/jquery.mCustomScrollbar.concat.min.js',
            '/frontend_assets/js/bootstrap-datepicker.min.js', '/frontend_assets/js/jquery.nice-select.min.js', '/frontend_assets/js/jquery.countdown.min.js',
            '/frontend_assets/js/swiper-bundle.min.js', '/frontend_assets/js/jarallax.min.js', '/frontend_assets/js/slick.min.js',
            '/frontend_assets/js/wow.min.js', '/frontend_assets/js/nav-tool.js', '/frontend_assets/js/plugins.js',
            '/frontend_assets/js/main.js'
        ];
        for (var i = 0; i < src.length; i++) {
            const script = document.createElement('script');
            script.src = src[i];
            script.async = false;
            // Ensure you have an element with id="scripts" in your main HTML file (e.g., index.html)
            document.body.appendChild(script);
        }

        this.getCategories();
        this.getUser();
        this.getCartData();
    },
    methods: {
        async removeCoupon() {
            try {
                this.couponName = '';
                let data = await axios.post(getUrlList().removeCoupon,
                    {
                        'token': this.user_info.user_id,
                        'auth': this.user_info.auth,
                    });
                if (data.status == 200) {
                    this.cartTotal = data.data.data.data;
                    this.couponName = data.data.data.couponName;
                }
                else {
                    console.log('Data Not Found');
                }
            } catch (error) {
                console.error('Error removing coupon:', error);
            }
        },

        async getUserCoupon() {
            try {
                let data = await axios.post(getUrlList().getUserCoupon,
                    {
                        'token': this.user_info.user_id,
                        'auth': this.user_info.auth,
                        'cartTotal': this.oldCart,
                    });
                if (data.status == 200) {
                    this.cartTotal = data.data.data.data;
                }
                else {
                    console.log('Data Not Found');
                }
            } catch (error) {
                console.error('Error getting user coupon:', error);
            }
        },

        async addCoupon(coupon) {
            try {
                let data = await axios.post(getUrlList().addCoupon,
                    {
                        'token': this.user_info.user_id,
                        'auth': this.user_info.auth,
                        'cartTotal': this.oldCart,
                        'coupon': coupon,
                    });
                if (data.status == 200) {
                    this.cartTotal = data.data.data.data;
                    this.couponName = data.data.data.couponName;
                }
                else {
                    console.log('Data Not Found');
                }
            } catch (error) {
                console.error('Error adding coupon:', error);
            }
        },

        async removeCartData(product_id, product_attr_id, qty) {
            try {
                let data = await axios.post(getUrlList().removeCartData,
                    {
                        'token': this.user_info.user_id,
                        'auth': this.user_info.auth,
                        'product_id': product_id,
                        'product_attr_id': product_attr_id,
                        'qty': qty,
                    });
                if (data.status == 200) {
                    this.getCartData();
                }
                else {
                    console.log('Data Not Found');
                }
            } catch (error) {
                console.error('Error removing cart data:', error);
            }
        },
        async addToCart(product_id, product_attr_id, qty) {
            if (product_id == '' || product_attr_id == '' || qty == '') {
                alert('select Color or qty');
            } else if (qty < 1) {
                alert('If qty is less than 1 then remove it');
                // You might want to call removeCartData here instead of just alerting
                this.removeCartData(product_id, product_attr_id, 1);
            }
            else {
                try {
                    let data = await axios.post(getUrlList().addToCart,
                        {
                            'token': this.user_info.user_id,
                            'auth': this.user_info.auth,
                            'product_id': product_id,
                            'product_attr_id': product_attr_id,
                            'qty': qty,
                        });
                    if (data.status == 200) {
                        this.getCartData();
                        alert('Item added to cart successfully!');
                    }
                    else {
                        console.log('Data Not Found');
                    }
                } catch (error) {
                    console.error('Error adding to cart:', error);
                }
            }
        },
        async getCartData() {
            try {
                let response = await axios.post(getUrlList().getCartData,
                    {
                        'token': this.user_info.user_id,
                        'auth': this.user_info.auth,
                    });
                if (response.status == 200) {
                    // The data is now in response.data.data.data
                    this.cartProduct = response.data.data.data;
                    this.cartCount = this.cartProduct.length;
                } else {
                    console.log('Data Not Found');
                }
            } catch (error) {
                console.error('Error fetching cart data:', error);
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
                console.error('Error getting user data:', error);
            }
        },
        async getCategories() {
            try {
                const response = await axios.get(getUrlList().getHeaderCategoriesData);
                if (response.status === 200 && response.data.data && response.data.data.length > 0) {
                    this.headerCategories = response.data.data;
                } else {
                    console.log('Data not found or API returned an empty list.');
                }
            } catch (error) {
                console.error('There was an error fetching the categories:', error.response || error);
            }
        }
    }
}
</script>
