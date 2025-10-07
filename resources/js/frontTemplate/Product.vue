<template>
    <Layout>
        <template v-slot:content="slotProps">

            <!-- main-area -->
            <main>

                <!-- breadcrumb-area -->
                <div class="breadcrumb-area breadcrumb-style-two" data-background="img/bg/s_breadcrumb_bg01.jpg">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 d-none d-lg-block">
                                <div class="previous-product">
                                    <a href="shop-details.html"><i class="fas fa-angle-left"></i> previous product</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="breadcrumb-content">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                            <li class="breadcrumb-item"><a href="shop.html">Winter 20</a></li>
                                            <li class="breadcrumb-item"><a href="shop.html">Women</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Tracker Jacket</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-lg-3 d-none d-lg-block">
                                <div class="next-product">
                                    <a href="shop-details.html">Next product <i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- breadcrumb-area-end -->

                <!-- shop-details-area -->
                <section class="shop-details-area pt-100 pb-95">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="shop-details-flex-wrap">
                                    <div class="shop-details-nav-wrap">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                                            <li v-for="(item, index) in images" :key="item.id" class="nav-item"
                                                role="presentation">
                                                <a :class="'nav-link ' + showActiveClass(1, index)"
                                                    :id="'item-' + item.id + '-tab'" data-toggle="tab"
                                                    :href="'#item-' + item.id" role="tab" aria-controls="item-one"
                                                    aria-selected="true"><img :src="item.image_url"
                                                        style="height:99px; width:117px;" alt=""></a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="shop-details-img-wrap">
                                        <div class="tab-content" id="myTabContent">

                                            <div v-for="(item, index) in images" :key="item.id"
                                                :class="'tab-pane fade ' + showActiveClass(2, index)"
                                                :id="'item-' + item.id" role="tabpanel"
                                                :aria-labelledby="'item-' + item.id + '-tab'">
                                                <div class="shop-details-img">
                                                    <img :src="item.image_url" style="height:621px; width:689px;"
                                                        alt="">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="shop-details-content">
                                    <!-- <a href="#" class="product-cat">Tracker Jacket</a> -->
                                    <h3 class="title">{{ product.name }}</h3>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p class="style-name">Style Name : {{ product.item_code }}</p>
                                    <div class="price">Price : Rs {{ product.product_attributer[0].price }}</div>
                                    <div class="product-details-info">
                                        <span>Size <a href="#">Guide</a></span>
                                        <div class="sidebar-product-size mb-30">
                                            <h4 class="widget-title">Product Size</h4>
                                            <div class="shop-size-list">
                                                <ul>
                                                    <li v-for="item in uniqueSizes"><a href="javascript:void(0)"
                                                            v-on:click="showColor(item), this.size = item"
                                                            :class="this.size == item ? sizeColor : ''">{{ item }}</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="sidebar-product-color">
                                            <h4 class="widget-title">Color</h4>
                                            <div class="shop-color-list">
                                                <ul>
                                                    <li v-for="item in uniqueColors"
                                                        v-on:click="this.color.id = item.id, this.color.text = item.text, this.color.product_attr_id = item.product_attr_id"
                                                        :style="{ backgroundColor: item.value }"
                                                        :class="this.color.id == item.id ? colorColor : ''"></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="perched-info">
                                        <div class="cart-plus-minus">
                                            <form action="#" class="num-block">
                                                <input type="text" class="in-num" v-model="qty" readonly>
                                                <div class="qtybutton-box">
                                                    <span class="plus" v-on:click="qty += 1">
                                                        <img src="/frontend_assets/img/icon/plus.png" alt="">
                                                    </span>
                                                    <span class="minus dis" v-on:click="qty -= 1">
                                                        <img src="/frontend_assets/img/icon/minus.png" alt="">
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                        <a href="javascript:void(0)"
                                            v-on:click="slotProps.addToCart(this.product.id, this.color.product_attr_id, this.qty)"
                                            class="btn">add to cart</a>
                                        <div class="wishlist-compare">
                                            <ul>
                                                <li><a href=""><i class="far fa-heart"></i> Add To Cart</a></li>
                                                <li><a href="#"><i class="fas fa-retweet"></i> Add to Compare List</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-details-share">
                                        <ul>
                                            <li>Share :</li>
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="product-desc-wrap">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="description-tab" data-toggle="tab"
                                                href="#description" role="tab" aria-controls="description"
                                                aria-selected="true">Description Guide</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews"
                                                role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                                            aria-labelledby="description-tab">
                                            <div class="product-desc-title mb-30">
                                                <h4 class="title">Additional information :</h4>
                                            </div>
                                            <p><span v-html="product.description"></span></p>


                                        </div>
                                        <div class="tab-pane fade" id="reviews" role="tabpanel"
                                            aria-labelledby="reviews-tab">
                                            <div class="product-desc-title mb-30">
                                                <h4 class="title">Reviews (0) :</h4>
                                            </div>
                                            <p>Your email address will not be published. Required fields are marked</p>
                                            <p class="adara-review-title">Be the first to review “Adara”</p>
                                            <div class="review-rating">
                                                <span>Your rating *</span>
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                            <form action="#" class="comment-form review-form">
                                                <span>Your review *</span>
                                                <textarea name="message" id="comment-message"
                                                    placeholder="Your Comment"></textarea>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" placeholder="Your Name*">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="email" placeholder="Your Email*">
                                                    </div>
                                                </div>
                                                <div class="comment-check-box">
                                                    <input type="checkbox" id="comment-check">
                                                    <label for="comment-check">Save my name and email in this browser
                                                        for the next time I comment.</label>
                                                </div>
                                                <button class="btn">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="related-product-wrap">
                            <div class="row">
                                <div class="col-12">
                                    <div class="related-product-title">
                                        <h4 class="title">You May Also Like...</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row related-product-active">
                                <div v-for="item in slotProps.otherProducts" :key="item.id" class="col-xl-3">
                                    <div class="new-arrival-item text-center">
                                        <div class="thumb mb-25">
                                            <a href="shop-details.html"><img :src="item.product.image_url" alt=""></a>
                                            <div class="product-overlay-action">
                                                <ul>
                                                    <li><a href="javascript:void(0)"
                                                            v-on:click="slotProps.addToCart(item.product_id, item.product_attr_id, item.qty, 1)"><i
                                                                class="far fa-heart"></i></a></li>
                                                    <li><a href="shop-details.html"><i class="far fa-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h5><a href="shop-details.html">{{ item.product.name }}</a></h5>
                                            <span class="price">{{ item.attribute.price }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- shop-details-area-end -->

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
    name: 'Product',
    components: {
        Layout
    },
    data() {
        return {
            slug: '',
            item_code: '',
            product: {
                name: '',
                item_code: '',
                product_attributer: [{
                    price: '',
                    images: []
                }]
            },
            images: [],
            colors: [],
            sizes: [],
            uniqueSizes: [],
            uniqueColors: [],
            size: '',
            color: { id: '', text: '', product_attr_id: '' }, // CORRECTED
            sizeColor: ' sizeColor',
            colorColor: ' colorColor',
            qty: 1,
            otherProducts: [],
        }
    },
    watch: {
        '$route.params.slug'() {
            this.getProduct();
        },
        qty(val) {
            if (val < 1) {
                this.qty = 1;
            }
        }
    },
    mounted() {
        this.getProduct();
    },
    methods: {
        showColor(size) {
            this.uniqueColors = [];
            this.size = size; // Set the selected size

            // Reset the selected color
            this.color = { id: '', text: '', product_attr_id: '' };

            // Filter colors based on the selected size
            this.uniqueColors = this.colors.filter(c => c.size === size);

            // Auto-select color if only one is available for the chosen size
            if (this.uniqueColors.length === 1) {
                this.color.id = this.uniqueColors[0].id;
                this.color.text = this.uniqueColors[0].text;
                this.color.product_attr_id = this.uniqueColors[0].product_attr_id;
            }
        },
        showActiveClass(type, index) {
            if (type == 1 && index == 0) {
                return 'active';
            } else if (type == 2 && index == 0) {
                return 'show active';
            }
        },
        async getProduct() {
            try {
                this.item_code = this.$route.params.item_code;
                this.slug = this.$route.params.slug;

                if (!this.slug || !this.item_code) {
                    this.$router.push({ name: 'Index' });
                    return;
                }

                const response = await axios.get(getUrlList().getProductData + '/' + this.item_code + '/' + this.slug);
                console.log('API Response:', response.data);

                if (response.status === 200 && response.data.data && response.data.data.product) {
                    this.product = response.data.data.product;
                    this.otherProducts = response.data.data.otherProducts;

                    this.images = [];
                    this.colors = [];
                    this.sizes = [];

                    for (const attribute of this.product.product_attributer) {
                        if (attribute.images && attribute.images.length > 0) {
                            this.images.push(...attribute.images);
                        }

                        // Use 'attribute' variable here
                        this.colors.push({
                            id: attribute.colors.id,
                            text: attribute.colors.text,
                            value: attribute.colors.value,
                            product_attr_id: attribute.id,
                            size: attribute.sizes.text,
                        });
                        this.sizes.push({
                            id: attribute.sizes.id,
                            text: attribute.sizes.text,
                            product_attr_id: attribute.id,
                        });
                    }

                    this.uniqueSizes = [...new Set(this.sizes.map(item => item.text))];

                    // Automatically select the first size and trigger color update
                    if (this.uniqueSizes.length > 0) {
                        this.showColor(this.uniqueSizes[0]);
                    }

                } else {
                    console.log('Product not found or API returned an empty response.');
                }

            } catch (error) {
                console.error('There was an error fetching the product data:', error);
            }
        }
    }
}
</script>
<style>
.brandColor::before {
    background-color: #FF5400;
}

.sizeColor {
    background-color: #FF5400;
    color: #ffff;
}

.colorColor::before {
    content: '\2713';
    display: inline-block;
    color: red;
    padding: 0 6px 0 0;
}
</style>