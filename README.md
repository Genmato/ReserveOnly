# ReserveOnly
Force only reservable products in cart

This extension adds a new Product Attribute (`reserved_product_only` or Tab `Reserve Product` => `Reservable Product` on product edit page). When set to 'Yes', it is not possible to checkout when there are normal products and reservable products in the cart. And message is displayed of the error (can be set in System=>Configuration=>Catalog=>Reserved Only Products=>Message).

It is also possible to specify the Payment method to use for Reservable products, when there are only reservable products in the cart then only this payment method is selectable, otherwise this payment method is hidden from the payment methods listed.
