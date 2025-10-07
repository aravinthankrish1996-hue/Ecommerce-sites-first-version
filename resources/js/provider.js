export function getUrlList() {
    const baseUrl = 'http://127.0.0.1:8000/api';
    return {
        getHeaderCategoriesData: '' + baseUrl + '/getHeaderCategoriesData',
        getHomeData: '' + baseUrl + '/getHomeData',
        getCategoryData: '' + baseUrl + '/getCategoryData',
        getUserData: '' + baseUrl + '/getUserData',
        getCartData: '' + baseUrl + '/getCartData',
        addToCart: '' + baseUrl + '/addToCart',
        removeCartData: '' + baseUrl + '/removeCartData',
        getProductData: '' + baseUrl + '/getProductData',
        addCoupon: '' + baseUrl + '/addCoupon',
        removeCoupon: '' + baseUrl + '/removeCoupon',
        getUserCoupon: '' + baseUrl + '/getUserCoupon',
        getPincodeDetails: '' + baseUrl + '/getPincodeDetails',
        placeOrder: '' + baseUrl + '/placeOrder',
        makePaymentOnline: '' + baseUrl + '/makePaymentOnline',
        getMyOrders: '' + baseUrl + '/getMyOrders',
        MyOrdersDetails: '' + baseUrl + '/MyOrdersDetails',
    }
}
export default getUrlList;