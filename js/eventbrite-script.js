(function (data) {
    console.log('eventbrite widget loaded', data);
    var defaultCallback = function () {
        console.log('Order complete!');
    };

    // Docs: https://www.eventbrite.com/platform/docs/embedded-checkout
    window.EBWidgets.createWidget({
        // Required
        widgetType: 'checkout',
        eventId: data.eventId,
        iframeContainerId: data.id,

        // Optional
        // promoCode : 'CODEHERE',
        iframeContainerHeight: parseInt( data.iframeContainerHeight ),  // Widget height in pixels. Defaults to a minimum of 425px if not provided
        onOrderComplete: defaultCallback  // Method called when an order has successfully completed
    });
})(btaEventbrite);