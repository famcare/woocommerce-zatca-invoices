[![GitHub PR](https://img.shields.io/github/issues-pr/famcare/WooCommerce-ZATCA-QR-invoice)](https://github.com/famcare/WooCommerce-ZATCA-QR-invoice)

## Contributors
[![GitHub Contributors](https://img.shields.io/github/contributors/famcare/WooCommerce-ZATCA-QR-invoice)](https://github.com/famcare/WooCommerce-ZATCA-QR-invoice)

![Your Repository's Stats](https://contrib.rocks/image?repo=famcare/WooCommerce-ZATCA-QR-invoice)

## About ZATCA QR Invoice for WooCommerce
An open-source initiative that belongs to [Famcare.app](https://famcare.app), Allow WooCommerce stores to issue ZATCA QR invoices.

## Getting Started
- [Download the latest version](https://github.com/famcare/WooCommerce-ZATCA-QR-invoice/archive/refs/heads/main.zip)
- Install and active it!
- Go to WooCommerce > Settings > General > ZATCA, fill the seller name and tax number.
- 

## Features

- Add QR code to PDF invoices (using [Print Invoice & Delivery Notes for WooCommerce Plugin](https://wordpress.org/plugins/woocommerce-delivery-notes/))
- Add QR code image to REST-API order object
- Add QR code to user dashboard order page.
```json
{
  "qr_code" : "https://famcare.app/link_to_image.png"
}
```
## Contributing

Contribution, issues and feature request are welcome!

Feel free to contribute in any way you want.

1. Fork the Project
2. Create your Feature Branch (git checkout -b feature/AmazingFeature)
3. Commit your Changes (git commit -m 'Add some AmazingFeature')
4. Push to the Branch (git push origin feature/AmazingFeature)
5. Open a Pull Request