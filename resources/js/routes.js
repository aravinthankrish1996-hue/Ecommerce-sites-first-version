import { createWebHistory, createRouter } from 'vue-router'

import Index from './frontTemplate/Index.vue';

import Category from './frontTemplate/Category.vue';

import Product from './frontTemplate/Product.vue';

import ShoppingCart from './frontTemplate/ShoppingCart.vue';

import Checkout from './frontTemplate/Checkout.vue';


import CreatePayment from './frontTemplate/CreatePayment.vue';

import ShowPaymentThankyou from './frontTemplate/ShowPaymentThankyou.vue';

import Myorders from './frontTemplate/Myorders.vue';

import MyOrdersDetails from './frontTemplate/MyOrdersDetails.vue';


const routes = [

    {
        name: 'Index',
        path: '/',
        component: Index,

    },
     {
        name: 'Category',
        path: '/category/:slug?',
        component: Category,

    },
       {
        name: 'Product',
        path: '/product/:item_code?/:slug?',
        component: Product,

    },
        {
        name: 'ShoppingCart',
        path: '/ShoppingCart',
        component: ShoppingCart,

    },
          {
        name: 'Checkout',
        path: '/checkout',
        component: Checkout,

    },
        {
        name: 'CreatePayment',
        path: '/CreatePayment/:url_token',
        component: CreatePayment,

    },
        {
        name: 'ShowPaymentThankyou',
        path: '/showPaymentThankyou/:status?/:transaction_id?',
        component: ShowPaymentThankyou,

    },
     {
        name: 'Myorders',
        path: '/myorders/:status?/:transaction_id?',
        component: Myorders,

    },
       {
        name: 'MyOrdersDetails',
        path: '/myOrdersDetails/:order_id',
        component: MyOrdersDetails,

    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
