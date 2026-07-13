let unitPrice = 125;
let quantity = 5;
let totalAmount = unitPrice * quantity;
let discount;
if (totalAmount > 5000) {
  discount = totalAmount * 0.1;
  totalAmount -= discount;
}
else {
  discount = 0;
}
let discountStatus = discount == 0 ? "No Discount" : "Discount Applied";
console.log("Total Amount: " + totalAmount);
console.log(discountStatus);