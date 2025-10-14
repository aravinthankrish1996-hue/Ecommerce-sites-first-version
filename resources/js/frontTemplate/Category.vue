<template>
  <Layout>
    <template v-slot:content>
      <section class="breadcrumb-area breadcrumb-bg"
        data-background="">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h2>Shop Sidebar</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="shop-area pt-100 pb-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-9 col-lg-8">
              <div class="shop-top-meta mb-35">
                <div class="row">
                  <div class="col-md-6">
                    <div class="shop-top-left">
                      <ul>
                        <li><a href="#"><i class="flaticon-menu"></i> FILTER</a></li>
                        <li>Showing 1–9 of 80 results</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="shop-top-right">
                      <form action="#">
                        <select name="select">
                          <option value="">Sort by newness</option>
                          <option>Free Shipping</option>
                          <option>Best Match</option>
                          <option>Newest Item</option>
                          <option>Size A - Z</option>
                        </select>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" :key="products.total">
                <template v-if="products && products.data && products.data.length > 0">
                  <div v-for="item in products.data" :key="item.id" class="col-xl-4 col-sm-6">
                    <div class="new-arrival-item text-center mb-50">
                      <div class="thumb mb-25">
                        <a :href="`/shop-details/${item.slug}`">
                          <img :src="item.image_url" :alt="item.name"
                            style="height:296px; width: 344px; object-fit: cover;">
                        </a>
                        <div class="product-overlay-action">
                          <ul>
                            <li><a href="#" @click.prevent="addToWishlist(item.id)"><i class="far fa-heart"></i></a></li>
                            <li><a :href="`/shop-details/${item.slug}`"><i class="far fa-eye"></i></a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="content">
                        <h5><a :href="`/shop-details/${item.slug}`">{{ item.name }}</a></h5>
                        <span v-if="item.product_attributer && item.product_attributer.length > 0" class="price">
                          Rs {{ item.product_attributer[0].price }}
                        </span>
                      </div>
                    </div>
                  </div>
                </template>
                <div v-else class="col-12">
                  <div class="text-center py-5">
                    <h4 class="text-muted">No Products Found</h4>
                    <p class="text-muted">Try adjusting your filters to find what you're looking for.</p>
                  </div>
                </div>
              </div>
              <div class="pagination-wrap">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
              <aside class="shop-sidebar">
                <div class="widget side-search-bar">
                  <form action="#">
                    <input type="text">
                    <button><i class="flaticon-search"></i></button>
                  </form>
                </div>
                <div class="widget">
                  <h4 class="widget-title">Product Categories</h4>
                  <div class="shop-cat-list">
                    <ul>
                      <li v-for="item in categories" :key="item.id">
                        <router-link :to="'/category/' + item.slug">{{ item.name }}</router-link>
                        <span>(6)</span>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="widget">
                  <h4 class="widget-title">Price Filter</h4>
                  <div class="price_filter">
                    <div id="slider-range"></div>
                    <div class="price_slider_amount">
                      <span>Price :</span>
                      <input type="text" v-model="lowPrice" @keypress="isNumber($event)" ref="lowPrice" id="lowPrice" placeholder="Low Price" />
                      <input type="text" v-model="highPrice" ref="highPrice" @keypress="isNumber($event)" id="highPrice" placeholder="High Price" />
                    </div>
                  </div>
                </div>
                <div v-for="item in attributers" :key="item.id" class="widget">
                  <h4 class="widget-title">{{ item.attributer.name }}</h4>
                  <div class="sidebar-brand-list">
                    <ul>
                      <li v-for="attrItem in item.attributer.values" :key="attrItem.id"
                        v-on:click="addDataAttr('attributer', attrItem.id)">
                        <a :class="{ 'attributerColor': attributer.includes(attrItem.id) }" href="javascript:void(0)">
                          {{ attrItem.value }}<i class="fas fa-angle-double-right"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="widget">
                  <h4 class="widget-title">Product Brand</h4>
                  <div class="sidebar-brand-list">
                    <ul>
                      <li v-for="item in brands" :key="item.id" v-on:click="addDataAttr('brand', item.id)">
                        <a :class="{ 'brandColor': brand.includes(item.id) }" href="javascript:void(0)">
                          {{ item.text }}<i class="fas fa-angle-double-right"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="widget has-border">
                  <div class="sidebar-product-size mb-30">
                    <h4 class="widget-title">Product Size</h4>
                    <div class="shop-size-list">
                      <ul>
                        <li v-for="item in sizes" :key="item.id" v-on:click="addDataAttr('size', item.id)">
                          <a :class="{ 'sizeColor': size.includes(item.id) }" href="javascript:void(0)">
                            {{ item.text }}
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="sidebar-product-color">
                    <h4 class="widget-title">Color</h4>
                    <div class="shop-color-list">
                      <ul>
                        <li v-for="item in colors" :key="item.id" v-on:click="addDataAttr('color', item.id)"
                          :class="{ 'active': color.includes(item.id) }" :style="{ backgroundColor: item.value }">
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="cart-coupon">
                    <form>
                      <!-- <button type="button" v-on:click="getProducts" class="btn">FILTER</button> -->
                    </form>
                  </div>
                </div>
                <!-- <div class="widget">
                  <h4 class="widget-title">Top Items</h4>
                  <div class="sidebar-product-list">
                    </div>
                </div> -->
              </aside>
            </div>
          </div>
        </div>
      </section>
    </template>
  </Layout>
</template>

<script>
import Layout from './Layout.vue';
import axios from 'axios';
import getUrlList from '../provider.js';

export default {
  name: 'Category',
  components: {
    Layout
  },
  data() {
    return {
      categories: [],
      products: [],
      brands: [],
      sizes: [],
      colors: [],
      attributers: [],
      category: null,
      highPrice: null,
      lowPrice: null,
      slug: null,
      // Filter state arrays
      brand: [],
      size: [],
      color: [],
      attributer: [],
    }
  },
  watch: {
    // Re-fetch products if the category slug in the URL changes
    '$route.params.slug'() {
      // Reset filters when changing category for a clean slate
      this.brand = [];
      this.size = [];
      this.color = [];
      this.attributer = [];
      this.getProducts();
    }
  },
  mounted() {
    console.log('Category component mounted. Fetching data...');
    this.getProducts();
  },
  methods: {
    // This function handles adding/removing filter criteria
    addDataAttr(type, value) {
      let array = this[type];
      const index = array.indexOf(value);

      if (index > -1) {
        array.splice(index, 1); // Remove item if it already exists
      } else {
        array.push(value); // Add item if it doesn't exist
      }
      
      // Call getProducts immediately to apply the filter for a better UX
      // The filter button is now only needed for the price range
      this.getProducts();
    },

    async getProducts() {
      try {
        this.slug = this.$route.params.slug;
        console.log('Fetching products for slug:', this.slug);

        if (!this.slug) {
          this.$router.push({ name: 'Index' });
          return;
        }

        const response = await axios.post(getUrlList().getCategoryData, {
          "slug": this.slug,
          "attributer": this.attributer,
          "lowPrice": this.lowPrice,
          "highPrice": this.highPrice,
          "brand": this.brand,
          "size": this.size,
          "color": this.color,
        });

        console.log('API Response:', response.data);

        if (response.status === 200 && response.data.data) {
          const data = response.data.data;

          // Only update sidebar filter options if they haven't been loaded yet
          // This prevents the sidebar from resetting on every filter action
          if (this.categories.length === 0) {
              this.categories = data.categories || [];
              this.brands = data.brands || [];
              this.sizes = data.sizes || [];
              this.colors = data.colors || [];
              this.attributers = data.attributer || [];
              this.highPrice = data.highPrice;
              this.lowPrice = data.lowPrice;
          }
          
          this.products = data.products || { data: [] }; // Ensure products is an object with a data array

          console.log('Data loaded successfully.');
        } else {
          this.products = { data: [] }; // Reset products on failure
          console.log('Data not found or API returned an empty response.');
        }
      } catch (error) {
        console.error('There was an error fetching the category data:', error);
      }
    }
  }
}
</script>

<style>
/* The color-related CSS classes were confusingly named and applied.
  Here's a simpler, corrected approach.
*/
.brandColor::before, .attributerColor::before {
  background-color: #FF5400;
}

.sizeColor {
  background-color: #FF5400;
  color: #ffff;
}

.shop-color-list li.active {
  border: 2px solid #FF5400; /* Add a visible border to indicate selection */
}
.shop-color-list li.active::before {
    content: '\2713'; /* Checkmark symbol */
    display: inline-block;
    color: #fff;
    position: relative;
    top: -10px;
    left: -10px;
    font-size: 14px;
}
</style>