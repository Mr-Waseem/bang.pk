<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\GRNController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WastageController;
use App\Http\Controllers\CatagoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FindSaleController;
use App\Http\Controllers\LCReportController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesTaxController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LCAccountController;
use App\Http\Controllers\LCExpenseController;
use App\Http\Controllers\LCPaymentController;
use App\Http\Controllers\MilkCarryController;
use App\Http\Controllers\OrderFormController;
use App\Http\Controllers\PhoneBookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RepairingController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CreditSaleController;
use App\Http\Controllers\LCApprovedController;
use App\Http\Controllers\LCIndentorController;
use App\Http\Controllers\LCLocationController;
use App\Http\Controllers\PostChequeController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProfitLossController;
use App\Http\Controllers\SaleReportController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\StockIssueController;
use App\Http\Controllers\AccountHeadController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BankPaymentController;
use App\Http\Controllers\BankReceiptController;
use App\Http\Controllers\CashPaymentController;
use App\Http\Controllers\CashReceiptController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\ExpenseHeadController;
use App\Http\Controllers\OpeningBalanceVoucher;
use App\Http\Controllers\ProductRateController;
use App\Http\Controllers\PurchaseTaxController;
use App\Http\Controllers\SalarySheetController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\AllPartySaleController;
use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\OpeningStockController;
use App\Http\Controllers\PrintReportsController;
use App\Http\Controllers\PurchaseMilkController;
use App\Http\Controllers\TrialBalanceController;
use App\Http\Controllers\TrialBalanceBookKeepingController;
use App\Http\Controllers\VouchersEditController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\LCInformationController;
use App\Http\Controllers\SaleTaxReportController;
use App\Http\Controllers\StockRegisterController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\TotalLossGainController;
use App\Http\Controllers\WastageReportController;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\CashBookReportController;
use App\Http\Controllers\ChequeTransferController;
use App\Http\Controllers\CollectionMilkController;
use App\Http\Controllers\GeneralVoucherController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\RecipeCreationController;
use App\Http\Controllers\SalePointStockController;
use App\Http\Controllers\SupplierLedgerController;
use App\Http\Controllers\UserSaleReportController;
use App\Http\Controllers\BranchWiseCustomerBalance;
use App\Http\Controllers\ClientAllReportController;
use App\Http\Controllers\DeliveryChallanController;
use App\Http\Controllers\FindCashPaymentController;
use App\Http\Controllers\FindCashReceiptController;
use App\Http\Controllers\ProductionStockController;
use App\Http\Controllers\SinglePartySaleController;
use App\Http\Controllers\WareHouseReportController;
use App\Http\Controllers\AllPartyPurchaseController;
use App\Http\Controllers\AttendanceReportController;
use App\Http\Controllers\AttendanceSingleController;
use App\Http\Controllers\CreditCashReportController;
use App\Http\Controllers\LedgerDetailWiseController;
use App\Http\Controllers\ProductionReportController;
use App\Http\Controllers\RawMaterialStockController;
use App\Http\Controllers\SampleBillReportController;
use App\Http\Controllers\PurchaseTaxReportController;
use App\Http\Controllers\StockCatagoryWiseController;
use App\Http\Controllers\SinglePartyPurchaseController;
use App\Http\Controllers\StockTransferReportController;
use App\Http\Controllers\WarehouseStockReportController;
use App\Http\Controllers\RawMaterialToSalePointController;
use App\Http\Controllers\StockIssueReportController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\ProductReportController;
use App\Http\Controllers\ScenarioController;
use App\Http\Controllers\SROScheduleController;
use App\Http\Controllers\SROItemnoController;
use App\Http\Controllers\FbrInvoiceController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\PosSalesTaxController;
use App\Http\Controllers\PosCreditNoteController;
use App\Http\Controllers\AdminCompanyReportController;
use App\Http\Controllers\DeveloperModeController;
use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CopyCustomerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// use LaravelQRCode\Facades\QRCode;

// Route::get('qr-code', function () 
// {
//   return QRCode::text('QR Code Generator for Laravel!')->svg();    
// });


// Cache Clear Route
Route::get('optimize-clear', function () {
	Artisan::call('optimize:clear');

	return response()->json([
		'status' => 'ok',
		'message' => 'Optimize cache cleared.',
	]);
})->middleware('auth');

// Cache Build Route (run once after deploy on production)
Route::get('optimize-cache', function () {
	$results = [];

	foreach (['config:cache', 'route:cache', 'view:cache'] as $command) {
		try {
			Artisan::call($command);
			$results[$command] = 'ok';
		} catch (\Throwable $e) {
			$results[$command] = $e->getMessage();
		}
	}

	return response()->json([
		'status' => 'ok',
		'message' => 'Production caches built.',
		'results' => $results,
	]);
})->middleware('auth');

// Route::get('/', function () {
// 	return view('auth.login');
// });
Route::get('/', [FbrInvoiceController::class, 'index']);
Route::get('/faq', [FbrInvoiceController::class, 'faq'])->name('website.faq');
Route::get('/privacy-policy', [FbrInvoiceController::class, 'privacyPolicy'])->name('website.privacy-policy');
Route::get('/terms-and-conditions', [FbrInvoiceController::class, 'termsAndConditions'])->name('website.terms-and-conditions');
// Route::post('/form', [FbrInvoiceController::class, 'submitForm'])->name('form.submit');
Route::post('/public_partner', [FbrInvoiceController::class, 'publicPartner']);
Auth::routes();
Route::match(['get','post'],'/logout',[App\Http\Controllers\Auth\LoginController::class,'logout']);
Route::get('/home', [HomeController::class, 'index']);

//Dashboard
Route::get('autocomplete', [AutocompleteController::class, 'index']);
Route::post('autocomplete/fetch', [AutoCompleteController::class, 'store'])->name('autocomplete.fetch');
Route::get('calender', [DashboardController::class, 'calender']);

//GRN
Route::resource('grn', GRNController::class);
Route::get('grn/print/{id}', [GRNController::class, 'print_challan']);
Route::get('grn/{id}/destroy', [GRNController::class, 'destroy']);
Route::get('grnproductmouseup-ajax', [GRNController::class, 'ProductKeyUp']);

//Delivery Challan
Route::resource('delivery-challan', DeliveryChallanController::class);
Route::get('delivery-challan/dcproductmouseup-ajax', [DeliveryChallanController::class, 'ProductKeyUp']);
Route::get('delivery-challan/{id}/destroy', [DeliveryChallanController::class, 'destroy']);
Route::get('delivery-challan/print/{id}', [DeliveryChallanController::class, 'print_challan']);

//Route::post('purchases/{id}', 'PurchaseController@update');
Route::get('purchases/{id}/destroy', [PurchaseController::class, 'destroy']);
Route::get('purchases/print/{id}', [PurchaseController::class, 'print_purchase']);
Route::get('purchases/getPDF/{id}', [PurchaseController::class, 'getPDF']);
Route::get('purchasetab-ajax', [PurchaseController::class, 'unit_cost']);
Route::get('purchases/import-stock/create', [PurchaseController::class, 'createImportExcel']);
Route::post('purchases/import-stock', [PurchaseController::class, 'ImportExcel']);
Route::get('products-ajax', [PurchaseController::class, 'purchase_json']);
Route::get('codemouseup-ajax', [PurchaseController::class, 'codeMouseUp']);
Route::get('productmouseup-ajax', [PurchaseController::class, 'ProductKeyUp']);
Route::get('quantity-ajax', [PurchaseController::class, 'quantity_json']);
Route::get('grnmouseup-ajax', [PurchaseController::class, 'grnMouseUp']);



//Sales
Route::resource('sales', SalesController::class);

//Route::resource('attendance', AttendanceController::class);

Route::get('attendance/{id}/destroy', [AttendanceController::class, 'destroy']);

Route::get('attendance-keyup', [AttendanceController::class, 'LoadEmployees']);

Route::resource('samples', SampleController::class);
Route::post('samples/find', [SampleController::class, 'find']);
Route::get('samples/{id}/destroy', [SampleController::class, 'destroy']);

Route::resource('order-form', OrderFormController::class);
Route::post('order-form/find', [OrderFormController::class, 'find']);
Route::get('order-form/{id}/destroy', [OrderFormController::class, 'destroy']);

// Route::group(['middleware' => 'roles', 'roles' => ['Editor']], function () {
// 	Route::get('sales/create', [SalesController::class, 'create']);
// 	Route::get('sales/{id}', [SalesController::class, 'show']);
// 	Route::post('sales', [SalesController::class, 'store']);
// });

Route::get('sales/create', [SalesController::class, 'create']);
Route::get('sales/{id}', [SalesController::class, 'show']);
Route::post('sales', [SalesController::class, 'store']);

Route::get('sales/print/{id}', [SalesController::class, 'print_sale']);
Route::get('sales/salespdf/{id}', [SalesController::class, 'getOrderPDF']);
Route::get('sales/cost-update/saledetail', [SalesController::class, 'UpdateCost']);
Route::get('sales/autocomplete', [SalesController::class, 'search']);
//Route::get('sales/getPDF/{id}', 'SalesController@getPDF');
Route::get('saletab-ajax', [SalesController::class, 'CodeChange']);
//General Product Rate Product Search
Route::get('productkeyup-ajax', [SalesController::class, 'ProductSearch']);
//General Product Rate on Code
// Route::get('productkeyup-ajax', 'SalesController@ProductChange');
//Customer Product Rate
Route::get('productrate-ajax', [SalesController::class, 'ProductRate']);
Route::get('productkeyup-name', [SalesController::class, 'ProductChangeName']);
Route::get('productkeyup-recipe', [RecipeCreationController::class, 'ProductChangeName']);
Route::get('partyonchange-ajax', [SalesController::class, 'PartyChange']);
Route::get('products-ajax', [SalesController::class, 'purchase_json']);
Route::get('getfirstProduct-ajax', [SalesController::class, 'FirstProduct']);
Route::get('productonchange-ajax', [SalesController::class, 'productChange']);
Route::get('dcmouseup-ajax', [SalesController::class, 'DCMouseUp']);
Route::get('loadproducts-ajax', [SalesController::class, 'LoadProducts']);


Route::get('recipechange-ajax', [SalesController::class, 'RecipeDetails']);


//Supplier Ledger
// Route::get('ledger/suppliers', [SupplierLedgerController::class, 'index']);
// Route::get('ledger/suppliers/create', [SupplierLedgerController::class, 'create']);
// Route::post('ledger/suppliers', [SupplierLedgerController::class, 'store']);
// Route::get('ledger/suppliers/{id}', [SupplierLedgerController::class, 'show']);
// Route::get('ledger/suppliers/print/{id}', [SupplierLedgerController::class, 'printledger']);

// Route::resource('ledger', LedgerController::class);
// Route::get('ledger/{id}/destroy', [LedgerController::class, 'destroy']);
// Route::get('ledger/print/{id}', [LedgerController::class, 'print_ledger']);
// Route::get('ledger/getPDF/{id}', [LedgerController::class, 'getPDF']);


// Route::get('expenses/heads', [ExpenseHeadController::class, 'index']);
// Route::get('expenses/heads/create', [ExpenseHeadController::class, 'create']);
// Route::post('expenses/heads', [ExpenseHeadController::class, 'store']);
// Route::get('expenses/heads/{id}/edit', [ExpenseHeadController::class, 'edit']);
// Route::patch('expenses/heads/{id}', [ExpenseHeadController::class, 'update']);
// Route::get('expenses/heads/{id}/destroy', [ExpenseHeadController::class, 'destroy']);


// Route::get('expenses/print', [ExpenseController::class, 'print_expense']);
// Route::get('expenses/pdf', [ExpenseController::class, 'getPDF']);
// Route::get('expenses/downloadExcel', [ExpenseController::class, 'getExcel']);
// Route::resource('expenses', ExpenseController::class);
// Route::get('expenses/{id}/destroy', [ExpenseController::class, 'destroy']);

//Route::get('cash-receipts/{id}/destroy', 'CashReceiptController@destroy');
Route::post('cash-receipts/report', [CashReceiptController::class, 'report']);
//Profit and Loss Account

//Vouchers
Route::resource('account-head', AccountHeadController::class);
Route::get('account-head/{id}/destroy', [AccountHeadController::class, 'destroy']);
Route::get('account-head/print/{id}', [AccountHeadController::class, 'PrintLedger']);
Route::resource('opening-balance', OpeningBalanceVoucher::class);

//Route::resource('bank-payments', 'BankPaymentController');
Route::post('bank-payments/report', [BankPaymentController::class, 'report']);
//Route::get('bank-payments/{id}/destroy', 'BankPaymentController@destroy');


//Route::resource('cash-payments', 'CashPaymentController');


//Route::get('cash-payments/{id}/destroy', 'CashPaymentController@destroy');

Route::post('cash-payments/report', [CashPaymentController::class, 'report']);

//Route::resource('bank-receipts', 'BankReceiptController');

//Route::get('bank-receipts/{id}/destroy', 'BankReceiptController@destroy');


Route::resource('vouchers', VouchersEditController::class);
Route::get('vouchers/{id}/destroy', [VouchersEditController::class, 'destroy']);
Route::get('vouchers/print/{id}', [VouchersEditController::class, 'print_voucher']);



//Purchase
//Route::resource('purchases', 'PurchaseController');


//Route::get('opening-stock/{id}/destroy', 'OpeningStockController@destroy');
//Recipe
Route::resource('recipe', RecipeController::class);
Route::get('recipe/{id}/destroy', [RecipeController::class, 'destroy']);



//Route::get('recipekeyup-change', 'ProductionController@ProductChange');
// Route::get('recipekeyup-ajax', 'RecipeCreationController@ProductChange');

//production


//Purchase Tax invoice
Route::get('purchase-tax/search-suppliers', [PurchaseTaxController::class, 'searchSuppliersAjax']);
Route::get('purchase-tax/search-products', [PurchaseTaxController::class, 'searchProductsAjax']);
Route::resource('purchase-tax', PurchaseTaxController::class);
Route::get('grnonchange-ajax', [PurchaseTaxController::class, 'grnChange']);
// Route::get('purchase-tax/print/{id}', [PurchaseTaxController::class, 'print_purchase']);
Route::get('purchase-tax/{id}/destroy', [PurchaseTaxController::class, 'destroy']);
Route::get('taxpartyonchange-ajax', [SalesTaxController::class, 'PartyChange']);
Route::get('dconchange-ajax', [SalesTaxController::class, 'dcChange']);
Route::get('taxproductkeyup-ajax', [SalesTaxController::class, 'ProductChange']);
Route::get('purchasetaxproductkeyup-ajax', [PurchaseTaxController::class, 'ProductChange']);

//Sales Tax invoice
Route::resource('pos-credit-note', PosCreditNoteController::class);
Route::get('pos-credit-note/{id}/destroy', [PosCreditNoteController::class, 'destroy']);
Route::post('pos-salestax/bulk-destroy', [PosSalesTaxController::class, 'bulkDestroy']);
Route::post('pos-salestax/bulk-approve', [PosSalesTaxController::class, 'bulkApprove']);
Route::resource('pos-salestax', PosSalesTaxController::class);
Route::get('pos-salestax/print/{id}', [PosSalesTaxController::class, 'print_sale']);
Route::get('pos-salestax/{id}/pdf', [PosSalesTaxController::class, 'downloadPdf']);
Route::post('pos-salestax/{id}/email', [PosSalesTaxController::class, 'emailInvoice']);
Route::get('pos-salestax/{id}/destroy', [PosSalesTaxController::class, 'destroy']);
Route::match(['post'], 'pos-salestax/approved/sale-invoice', [PosSalesTaxController::class, 'approve']);
Route::post('salestax/bulk-destroy', [SalesTaxController::class, 'bulkDestroy']);
Route::post('salestax/bulk-approve', [SalesTaxController::class, 'bulkApprove']);
Route::get('salestax/search-parties', [SalesTaxController::class, 'searchPartiesAjax']);
Route::get('salestax/search-products', [SalesTaxController::class, 'searchProductsAjax']);
Route::resource('salestax', SalesTaxController::class);
Route::get('salestax/import-excel/create', [SalesTaxController::class, 'createImportExcel']);
Route::post('salestax/import-excel', [SalesTaxController::class, 'ImportExcel']);
Route::get('salestax/print/{id}', [SalesTaxController::class, 'print_sale']);
// Route::post('salestax/approved/sale-invoice', [SalesTaxController::class, 'approve']);
Route::match(['post'], 'salestax/approved/sale-invoice', [SalesTaxController::class, 'approve']);
Route::get('salestax/dcn/{id}', [SalesTaxController::class, 'print_dc']);
Route::get('salestax/salestaxpdf/{id}', [SalesTaxController::class, 'print_pdf']);
Route::get('salestax/{id}/pdf', [SalesTaxController::class, 'downloadPdf']);
Route::post('salestax/{id}/email', [SalesTaxController::class, 'emailInvoice']);
Route::get('salestax/{id}/destroy', [SalesTaxController::class, 'destroy']);
Route::get('taxpartyonchange-ajax', [SalesTaxController::class, 'PartyChange']);
Route::get('taxproductkeyup-ajax', [SalesTaxController::class, 'ProductChange']);
Route::get('sro-item/getsroschd/getsroitem', [SalesTaxController::class, 'getsro_item']);
//CreditNote
Route::get('debit-note/multidelete', [CreditNoteController::class, 'MultiDelete']);
Route::resource('debit-note', CreditNoteController::class);
Route::get('debit-note/print/{id}', [CreditNoteController::class, 'print_sale']);
Route::get('debit-note/dcn/{id}', [CreditNoteController::class, 'print_dc']);
Route::get('debit-note/credit-note-pdf/{id}', [CreditNoteController::class, 'print_pdf']);
// Route::match(['post'], 'salestax/approved/sale-invoice', [SalesTaxController::class, 'approve']);
Route::get('debit-note/{id}/destroy', [CreditNoteController::class, 'destroy']);
Route::post('debit-note/bulk-destroy', [CreditNoteController::class, 'bulkDestroy']);
Route::get('taxpartyonchange-ajax', [CreditNoteController::class, 'PartyChange']);
Route::get('taxproductkeyup-ajax', [CreditNoteController::class, 'ProductChange']);


Route::get('customer-rate-change', [ProductRateController::class, 'CustomerChange']);
Route::get('ratekeyup-ajax', [ProductRateController::class, 'LoadVoucher']);

//Route::resource('rawmaterial-to-salepoint', 'RawMaterialToSalePointController');

Route::get('rawmaterial-to-salepoint/{id}/destroy', [RawMaterialToSalePointController::class, 'destroy']);

//Route::resource('stock-transfer', 'StockTransferController');


Route::get('stock-transfer/{id}/destroy', [StockTransferController::class, 'destroy']);
Route::resource('warehouse-report', WareHouseReportController::class);
Route::resource('warehouse-stock-report', WarehouseStockReportController::class);


//Product Update Editable
Route::get('products/update-name/update', [ProductController::class, 'UpdateName']);
Route::get('products/update-code/update', [ProductController::class, 'UpdateCode']);
Route::get('products/update-cost/update', [ProductController::class, 'UpdateCost']);
Route::get('products/update-price/update', [ProductController::class, 'UpdatePrice']);
Route::get('products/update-weight/update', [ProductController::class, 'updateWeight']);
Route::get('products/update-alert/update', [ProductController::class, 'updateAlert']);

Route::get('rates/update-rate/update', [ProductRateController::class, 'UpdateMilkRate']);
Route::get('rates/update-supplier-rate/update', [ProductRateController::class, 'UpdateSupplierMilkRate']);

//Repairing
Route::resource('repairing', RepairingController::class);
Route::get('repairing/{id}/destroy', [RepairingController::class, 'destroy']);
Route::get('repairing/print/{id}', [RepairingController::class, 'print_repair']);

//Discounts
Route::resource('discount', DiscountController::class);
Route::get('discount/{id}/destroy', [DiscountController::class, 'destroy']);

//Supplier
// Route::resource('supplier', SupplierController::class);
// Route::get('supplier/{id}/destroy', [SupplierController::class, 'destroy']);
// Route::get('supplier/print/{id}', [SupplierController::class, 'print_supplier']);
// Route::get('supplier/getPDF/{id}', [SupplierController::class, 'getPDF']);

//Account Settings
Route::resource('account', AccountSettingController::class);
Route::resource('copy-customer', CopyCustomerController::class);
Route::resource('developer-mode', DeveloperModeController::class);
Route::resource('company-settings', CompanySettingsController::class);


Route::resource('stock-transfer-report', StockTransferReportController::class);
Route::get('cash-receipts/print/{id}', [CashReceiptController::class, 'print_cashReceipt']);
//Route::resource('cash-receipts', 'CashReceiptController');
Route::get('cash-receipts/create', [CashReceiptController::class, 'create']);
Route::get('cash-receipts/{id}', [CashReceiptController::class, 'show']);
Route::post('cash-receipts', [CashReceiptController::class, 'store']);

Route::get('cash-payments/create', [CashPaymentController::class, 'create']);
Route::get('cash-payments/{id}', [CashPaymentController::class, 'show']);
Route::post('cash-payments', [CashPaymentController::class, 'store']);

Route::resource('client-all-report', ClientAllReportController::class);
Route::get('get-selected-category-accounts', [ClientAllReportController::class, 'GetSelectedCategoryAccounts']);

Route::resource('sale-report', SaleReportController::class);
Route::resource('cash-book-report', CashBookReportController::class);

Route::resource('salepoint-stock', SalePointStockController::class);
Route::resource('branch-wise-customer-balance', BranchWiseCustomerBalance::class);


Route::get('credit-sales/create', [CreditSaleController::class, 'create']);
Route::get('credit-sales/{id}', [CreditSaleController::class, 'show']);
Route::post('credit-sales', [CreditSaleController::class, 'store']);
Route::get('credit-sales/print/{id}', [CreditSaleController::class, 'print_sale']);

Route::get('parties/import-excel/create', [PartyController::class, 'createImportExcel']);
Route::post('parties/import-excel', [PartyController::class, 'ImportExcel']);
Route::get('parties/{id}/destroy', [PartyController::class, 'destroy']);


Route::get('production', [ProductionController::class, 'index']);

Route::get('production/{id}/edit', [ProductionController::class, 'edit']);
Route::patch('production/{id}', [ProductionController::class, 'update']);
Route::get('production/{id}/destroy', [ProductionController::class, 'destroy']);

// Route::resource('trial-balance', 'TrialBalanceController');
Route::resource('profitloss', ProfitLossController::class);

Route::resource('balance-sheet', BalanceSheetController::class);

Route::resource('wastage', WastageController::class);
Route::get('wastage/{id}/destroy', [WastageController::class, 'destroy']);

Route::get('trial-balance/receiveables/all', [TrialBalanceController::class, 'Receiveables']);
Route::get('products/print', [ProductController::class, 'print_books']);
Route::get('products/pdf', [ProductController::class, 'getPDF']);
Route::get('products/downloadExcel', [ProductController::class, 'getExcel']);

Route::get('products/import-excel/create', [ProductController::class, 'createImportExcel']);
Route::post('products/import-excel', [ProductController::class, 'ImportExcel']);


// Route::get('products/importExcel/create', 'ProductController@createImportExcel');
// Route::post('products/importExcel', 'ProductController@ImportExcel');


Route::resource('products', ProductController::class);
Route::get('products/{id}/destroy', [ProductController::class, 'destroy']);
Route::get('products/getPDF/{id}', [ProductController::class, 'getPDF']);
Route::get('products/alert/stock', [ProductController::class, 'stockAlert']);
Route::get('hscode-ajax', [ProductController::class, 'hsCode']);
//Parties
Route::get('parties/print', [PartyController::class, 'print_parties']);
Route::get('parties/customers/print', [PartyController::class, 'print_customers']);
Route::get('parties/suppliers/print', [PartyController::class, 'print_suppliers']);
Route::get('parties/pdf', [PartyController::class, 'getPDF']);
Route::get('parties/downloadExcel', [PartyController::class, 'getExcel']);
Route::resource('parties', PartyController::class);
Route::post('parties/bulk-destroy', [PartyController::class, 'bulkDestroy']);
Route::get('parties/{id}/destroy', [PartyController::class, 'destroy']);
Route::get('parties/print/{id}', [PartyController::class, 'print_products']);

//Recipe
Route::resource('recipe-creation', RecipeCreationController::class);
Route::get('recipe-creation/{id}/destroy', [RecipeCreationController::class, 'destroy']);
Route::get('recipekeyup-recipe', [RecipeCreationController::class, 'LoadVoucher']);

//Users management
Route::resource('roles', RoleController::class);
Route::get('roles/{id}/destroy', [RoleController::class, 'destroy']);
Route::post('roles/adduser', [RoleController::class, 'addUser']);

Route::get('cash-payments', [CashPaymentController::class, 'index']);
Route::get('cash-payments/{id}/edit', [CashPaymentController::class, '@edit']);
Route::patch('cash-payments/{id}', [CashPaymentController::class, 'update']);
Route::get('cash-payments/{id}/destroy', [CashPaymentController::class, 'destroy']);


Route::get('cash-receipts', [CashReceiptController::class, 'index']);
Route::get('cash-receipts/{id}/edit', [CashReceiptController::class, 'edit']);
Route::patch('cash-receipts/{id}', [CashReceiptController::class, 'update']);
Route::get('cash-receipts/{id}/destroy', [CashReceiptController::class, 'destroy']);


Route::get('bank-receipts', [BankReceiptController::class, 'index']);
Route::get('bank-receipts/{id}/edit', [BankReceiptController::class, 'edit']);
Route::patch('bank-receipts/{id}', [BankReceiptController::class, 'update']);
Route::get('bank-receipts/{id}/destroy', [BankReceiptController::class, 'destroy']);

Route::get('general-voucher', [GeneralVoucherController::class, 'index']);
Route::get('general-voucher/{id}/edit', [GeneralVoucherController::class, 'edit']);
Route::patch('general-voucher/{id}', [GeneralVoucherController::class, 'update']);
Route::get('general-voucher/{id}/destroy', [GeneralVoucherController::class, 'destroy']);
//Route::resource('general-voucher', GeneralVoucherController::class);
Route::get('general-voucher/create', [GeneralVoucherController::class, 'create']);
Route::get('general-voucher/{id}', [GeneralVoucherController::class, 'show']);
Route::post('general-voucher', [GeneralVoucherController::class, 'store']);
//Route::get('general-voucher/{id}/destroy', 'GeneralVoucherController@destroy');
Route::post('general-voucher/report', [GeneralVoucherController::class, 'report']);

Route::get('bank-payments', [BankPaymentController::class, 'index']);
Route::get('bank-payments/{id}/edit', [BankPaymentController::class, 'edit']);
Route::patch('bank-payments/{id}', [BankPaymentController::class, 'update']);
Route::get('bank-payments/{id}/destroy', [BankPaymentController::class, 'destroy']);

//Route::resource('opening-stock', 'OpeningStockController');
Route::get('opening-stock/search-products', [OpeningStockController::class, 'searchProductsAjax']);
Route::get('opening-stock/create', [OpeningStockController::class, 'create']);
Route::get('opening-stock/{id}', [OpeningStockController::class, 'show']);
Route::post('opening-stock', [OpeningStockController::class, 'store']);
Route::get('opening-stock', [OpeningStockController::class, 'index']);
Route::get('opening-stock/{id}/edit', [OpeningStockController::class, 'edit']);
Route::patch('opening-stock/{id}', [OpeningStockController::class, 'update']);
Route::get('opening-stock/{id}/destroy', [OpeningStockController::class, 'destroy']);

Route::resource('account-group', AccountGroupController::class);
Route::get('account-group/{id}/destroy', [AccountGroupController::class, 'destroy']);

Route::get('purchases', [PurchaseController::class, 'index']);
Route::get('purchases/{id}/edit', [PurchaseController::class, 'edit']);
Route::patch('purchases/{id}', [PurchaseController::class, 'update']);
Route::get('purchases/{id}/destroy', [PurchaseController::class, 'destroy']);


Route::get('stock-transfer', [StockTransferController::class, 'index']);
Route::get('stock-transfer/{id}/edit', [StockTransferController::class, 'edit']);
Route::patch('stock-transfer/{id}', [StockTransferController::class, 'update']);
Route::get('stock-transfer/{id}/destroy', [StockTransferController::class, 'destroy']);


Route::get('rawmaterial-to-salepoint', [RawMaterialToSalePointController::class, 'index']);
Route::get('rawmaterial-to-salepoint/{id}/edit', [RawMaterialToSalePointController::class, 'edit']);
Route::patch('rawmaterial-to-salepoint/{id}', [RawMaterialToSalePointController::class, 'update']);
Route::get('rawmaterial-to-salepoint/{id}/destroy', [RawMaterialToSalePointController::class, 'destroy']);

Route::get('attendance', [AttendanceController::class, 'index']);
Route::get('attendance/{id}/edit', [AttendanceController::class, 'edit']);
Route::patch('attendance/{id}', [AttendanceController::class, 'update']);
Route::get('attendance/{id}/destroy', [AttendanceController::class, 'destroy']);

Route::resource('product-rates', ProductRateController::class);
Route::get('product-rates/{id}/destroy', [ProductRateController::class, 'destroy']);





Route::get('production/{id}/destroy', [ProductionController::class, 'destroy']);
Route::get('productkeyup-production', [ProductionController::class, 'showProductCode']);
Route::get('editproduction-modal', [ProductionController::class, 'editProducts']);
Route::get('productkeyup-change', [ProductionController::class, 'ProductChange']);
Route::get('productkeyup-change-print', [ProductionController::class, 'ProductChangePrint']);


// Route::get('collection-milk/create', [CollectionMilkController::class, 'create']);
// Route::get('collection-milk/{id}', [CollectionMilkController::class, 'show']);
// Route::post('collection-milk', [CollectionMilkController::class, 'store']);

// Route::get('carry-milk/create', [MilkCarryController::class, 'create']);
// Route::get('carry-milk/{id}', [MilkCarryController::class, 'show']);
// Route::post('carry-milk', [MilkCarryController::class, 'store']);



//for Collection Center dashboard
// Route::get('purchase-milk/center-report/create', [PurchaseMilkController::class, 'CollectionMilk']);
// Route::post('purchase-milk/center-report/report', [PurchaseMilkController::class, 'CollectionMilkReport']);
// Route::get('purchase-milk/supplier-wise/center/create', [PurchaseMilkController::class, 'SupplierWiseCenterReport']);
// Route::post('purchase-milk/supplier-wise/center/report', [PurchaseMilkController::class, 'findSupplierWiseCenterReport']);


// Route::resource('carry-milk', 'MilkCarryController');
// Route::get('purchase-milk/driver-report/create', [PurchaseMilkController::class, 'DriverReport']);
// Route::post('purchase-milk/driver-report/report', [PurchaseMilkController::class, 'findDriverReport']);


// Route::get('purchase-milk/vehicle-report/create', [PurchaseMilkController::class, 'VehicleReport']);
// Route::post('purchase-milk/vehicle-report/report', [PurchaseMilkController::class, 'findVehicleReport']);

//  Route::get('purchase-milk/location-wise/create', 'PurchaseMilkController@LocationWiseReport');
//  Route::post('purchase-milk/location-wise/report', 'PurchaseMilkController@findLocationWiseReport');

// Route::get('purchase-milk/supplier-wise/create', [PurchaseMilkController::class, 'SupplierWiseReport']);
// Route::post('purchase-milk/supplier-wise/report', [PurchaseMilkController::class, 'findSupplierWiseReport']);


// Route::get('purchase-milk/location-wise/create', [PurchaseMilkController::class, 'LocationWiseReport']);
// Route::post('purchase-milk/location-wise/report', [PurchaseMilkController::class, 'findLocationWiseReport']);



//for Author dashboard
Route::resource('wastage-report', WastageReportController::class);
// Route::get('purchase-milk/admin-report/create', [PurchaseMilkController::class, 'AdminMilk']);
// Route::post('purchase-milk/admin-report/report', [PurchaseMilkController::class, 'AdminMilkReport']);

// Route::get('purchase-milk/create', [PurchaseMilkController::class, 'create']);
// Route::get('purchase-milk/{id}', [PurchaseMilkController::class, 'show']);
// Route::post('purchase-milk', [PurchaseMilkController::class, 'store']);

Route::get('stock-transfer/create', [StockTransferController::class, 'create']);
Route::get('stock-transfer/{id}', [StockTransferController::class, 'show']);
Route::post('stock-transfer', [StockTransferController::class, 'store']);
Route::get('stock-transfer/print/{id}', [StockTransferController::class, 'print_transfer']);


Route::get('production/create', [ProductionController::class, 'create']);
Route::get('production/print-only', [ProductionController::class, 'PrintOnly']);
Route::get('production/print-recipe', [ProductionController::class, 'RecipePrint']);

Route::get('production/{id}', [ProductionController::class, 'show']);
Route::post('production', [ProductionController::class, 'store']);

Route::get('attendance/attendance-report/create', [AttendanceReportController::class, 'create']);
Route::post('attendance/attendance-report', [AttendanceReportController::class, 'store']);
Route::get('attendances/attendance-report', [AttendanceReportController::class, 'index']);
Route::post('attendances/attendance-report', [AttendanceReportController::class, 'singleEmployee']);

Route::resource('attendance-single', AttendanceSingleController::class);

Route::resource('production-report', ProductionReportController::class);
Route::post('production-report/all-item/allitem_report', [ProductionReportController::class, 'allItem']);
//Stock Regiter
Route::resource('stock-register-catagory-wise', StockCatagoryWiseController::class);
Route::resource('stock-register-specific-item', StockRegisterController::class);
Route::post('stock-register-specific-item/report', [StockRegisterController::class, 'report']);
Route::post('stock-register-specific-item-fifo/report', [StockRegisterController::class, 'reportFifo']);
Route::get('stock-register-specific-items/update', [StockRegisterController::class, 'updateuoms']);

Route::get('stock-register-specific-items/updated', [StockRegisterController::class, 'updateDate']);
Route::get('stock-register-specific-items/updated/salepoint', [StockRegisterController::class, 'updateDateSalePoint']);
//Item Wise Ledger
Route::resource('ledger-detail-wise', LedgerDetailWiseController::class);
Route::post('ledger-detail-wise/report', [LedgerDetailWiseController::class, 'report']);


// Route::resource('stock-transfer-report', 'StockTransferReportController');
Route::resource('production-stock', ProductionStockController::class);
Route::resource('raw-material', RawMaterialStockController::class);
Route::resource('admin-company-report', AdminCompanyReportController::class);

//Sale Report
Route::resource('credit-cash-report', CreditCashReportController::class);

//Settings
Route::resource('settings', SettingController::class);
Route::get('settings/{id}/destroy', [SettingController::class, 'destroy']);
Route::get('settings/{id}/edit', [SettingController::class, 'upload']);

Route::get('rawmaterial-to-salepoint/create', [RawMaterialToSalePointController::class, 'create']);
Route::get('rawmaterial-to-salepoint/{id}', [RawMaterialToSalePointController::class, 'show']);
Route::post('rawmaterial-to-salepoint', [RawMaterialToSalePointController::class, 'store']);


Route::get('purchases/create', [PurchaseController::class, 'create']);
Route::get('purchases/{id}', [PurchaseController::class, 'show']);
Route::post('purchases', [PurchaseController::class, 'store']);


Route::get('attendance/create', [AttendanceController::class, 'create']);
Route::get('attendance/{id}', [AttendanceController::class, 'show']);
Route::post('attendance', [AttendanceController::class, 'store']);

Route::get('bank-payments/create', [BankPaymentController::class, 'create']);
Route::get('bank-payments/{id}', [BankPaymentController::class, 'show']);
Route::post('bank-payments', [BankPaymentController::class, 'store']);

Route::get('bank-receipts/create', [BankReceiptController::class, 'create']);
Route::get('bank-receipts/{id}', [BankReceiptController::class, 'show']);
Route::post('bank-receipts', [BankReceiptController::class, 'store']);


Route::get('client-all-report/ledger-for-trial/{id}', [ClientAllReportController::class, 'ledgerForTrialBalance']);
Route::get('ledger-all-party', [ClientAllReportController::class, 'ledgerallpartyIndex']);
Route::post('ledger-all-party/report', [ClientAllReportController::class, 'LedgerAllParty']);
Route::get('ledger-all-party-detail', [ClientAllReportController::class, 'ledgerallpartyDetail']);
Route::post('ledger-all-party-detail/report', [ClientAllReportController::class, 'LedgerAllPartyReport']);
Route::get('find-sale/create', [FindSaleController::class, 'create']);
Route::post('find-sale', [FindSaleController::class, 'store']);


//Quotations
Route::resource('quotation', QuotationController::class);
Route::get('quotation/{id}/destroy', [QuotationController::class, 'destroy']);
Route::get('quotation/print/{id}', [QuotationController::class, 'print_quotation']);
Route::get('quotation/quotationpdf/{id}', [QuotationController::class, 'getQuotationPDF']);
Route::get('quotation-report', [QuotationController::class, 'quotationindex']);
Route::post('quotation-report/report', [QuotationController::class, 'quotationfind']);
Route::get('/getPDF', [QuotationController::class, 'getPDF']);





Route::group(['middleware' => 'checkCompanySession'], function () {
	Route::resource('dashboard', DashboardController::class);
	Route::resource('company', CompanyController::class);
	// Route::get('company/{id}/destroy', [CompanyController::class, 'destroy']);
	Route::get('company/assign/{id}', [CompanyController::class, 'AssignCompany']);
	Route::get('/logout-company', [CompanyController::class, 'LogoutCompany']);
});

/////////////////////////////ADMIN MIDDLEWARE STARTS////////////////////////////////////////
Route::resource('phonebook', PhoneBookController::class);
Route::get('phonebook/{id}/destroy', [PhoneBookController::class, 'destroy']);
Route::get('sales', [SalesController::class, 'index']);
Route::get('sales/{id}/edit', [SalesController::class, 'edit']);
Route::patch('sales/{id}', [SalesController::class, 'update']);
Route::get('sales/{id}/destroy', [SalesController::class, 'destroy']);

Route::get('collection-milk', [CollectionMilkController::class, 'index']);
Route::post('collection-milk/find', [CollectionMilkController::class, 'findCollection']);
Route::get('collection-milk/{id}/edit', [CollectionMilkController::class, 'edit']);
Route::patch('collection-milk/{id}', [CollectionMilkController::class, 'update']);
Route::get('collection-milk/{id}/destroy', [CollectionMilkController::class, 'destroy']);

Route::get('carry-milk', [MilkCarryController::class, 'index']);
Route::post('carry-milk/find', [MilkCarryController::class, 'findCarry']);
Route::get('carry-milk/{id}/edit', [MilkCarryController::class, 'edit']);
Route::patch('carry-milk/{id}', [MilkCarryController::class, 'update']);
Route::get('carry-milk/{id}/destroy', [MilkCarryController::class, 'destroy']);

Route::get('purchase-milk', [PurchaseMilkController::class, 'index']);
Route::post('purchase-milk/find', [PurchaseMilkController::class, 'findPurchase']);
Route::get('purchase-milk/{id}/edit', [PurchaseMilkController::class, 'edit']);
Route::patch('purchase-milk/{id}', [PurchaseMilkController::class, 'update']);
Route::get('purchase-milk/{id}/destroy', [PurchaseMilkController::class, 'destroy']);

Route::get('purchase-milk/report/create', [PurchaseMilkController::class, 'createReport']);
Route::post('purchase-milk/report', [PurchaseMilkController::class, 'findReport']);
Route::resource('total-lossgain', TotalLossGainController::class);



Route::get('purchase-milk/location-report/create', [PurchaseMilkController::class, 'LocationReport']);
Route::post('purchase-milk/location-report/report', [PurchaseMilkController::class, 'findLocationReport']);

// Route::resource('cash-book-report', CashBookReportController::class);
Route::resource('post-cheque-receipt', PostChequeController::class);
Route::get('post-cheque-receipt/{id}/destroy', [PostChequeController::class, 'destroy']);
Route::resource('cheque-transfer', ChequeTransferController::class);
Route::get('cheque-transfer/{id}/destroy', [ChequeTransferController::class, 'destroy']);
Route::get('credit-sales', [CreditSaleController::class, 'index']);
Route::get('credit-sales/{id}/edit', [CreditSaleController::class, 'edit']);
Route::patch('credit-sales/{id}', [CreditSaleController::class, 'update']);
Route::get('credit-sales/{id}/destroy', [CreditSaleController::class, 'destroy']);

Route::resource('vehicles', VehicleController::class);
Route::get('attendance', [AttendanceController::class, 'index']);
Route::get('attendance/{id}/edit', [AttendanceController::class, 'edit']);
Route::patch('attendance/{id}', [AttendanceController::class, 'update']);
Route::get('attendance/{id}/destroy', [AttendanceController::class, 'destroy']);
Route::resource('trial-balance', TrialBalanceController::class);
Route::resource('trial-balance-bookkeeping', TrialBalanceBookKeepingController::class);
Route::resource('profitloss', ProfitLossController::class);
Route::resource('wastage', WastageController::class);
Route::get('wastage/{id}/destroy', [WastageController::class, 'destroy']);
Route::resource('sales-report/single-party', SinglePartySaleController::class);
Route::resource('sales-report/all-party', AllPartySaleController::class);
//Route::post('sales-report/all-party/salepoint',[AllPartySaleController::class,'SalePoint]);
Route::resource('sales-report/user-sale', UserSaleReportController::class);
//Products

Route::get('products/print', [ProductController::class, 'print_books']);
Route::get('products/pdf', [ProductController::class, 'getPDF']);
Route::get('products/downloadExcel', [ProductController::class, 'getExcel']);

Route::resource('products', ProductController::class);
Route::get('products/{id}/destroy', [ProductController::class, 'destroy']);
Route::get('products/getPDF/{id}', [ProductController::class, 'getPDF']);
Route::get('products/alert/stock', [ProductController::class, 'stockAlert']);

//Parties
Route::get('parties/print', [PartyController::class, 'print_parties']);
Route::get('parties/pdf', [PartyController::class, 'getPDF']);
Route::get('parties/downloadExcel', [PartyController::class, 'getExcel']);
Route::resource('parties', PartyController::class);
Route::get('parties/{id}/destroy', [PartyController::class, 'destroy']);
Route::get('parties/print/{id}', [PartyController::class, 'print_products']);

//Recipe
Route::resource('recipe-creation', RecipeCreationController::class);
Route::get('recipe-creation/{id}/destroy', [RecipeCreationController::class, 'destroy']);
Route::get('recipekeyup-recipe', [RecipeCreationController::class, 'LoadVoucher']);

//Users management
Route::resource('roles', RoleController::class);
Route::get('roles/{id}/destroy', [RoleController::class, 'destroy']);
Route::post('roles/adduser', [RoleController::class, 'addUser']);

Route::get('sales', [SalesController::class, 'index']);
Route::get('sales/{id}/edit', [SalesController::class, 'edit']);
Route::patch('sales/{id}', [SalesController::class, 'update']);
Route::get('sales/{id}/destroy', [SalesController::class, 'destroy']);


Route::get('purchases', [PurchaseController::class, 'index']);
// Route::post('purchases-add', [PurchaseController::class, 'store']);
Route::get('purchases/{id}/edit', [PurchaseController::class, 'edit']);
Route::patch('purchases/{id}', [PurchaseController::class, 'update']);
Route::get('purchases/{id}/destroy', [PurchaseController::class, 'destroy']);

Route::resource('location', LocationController::class);
Route::get('location/{id}/destroy', [LocationController::class, 'destroy']);

Route::get('cash-payments', [CashPaymentController::class, 'index']);
Route::get('cash-payments/{id}/edit', [CashPaymentController::class, 'edit']);
Route::patch('cash-payments/{id}', [CashPaymentController::class, 'update']);
Route::get('cash-payments/{id}/destroy', [CashPaymentController::class, 'destroy']);

Route::get('cash-receipts', [CashReceiptController::class, 'index']);
Route::get('cash-receipts/{id}/edit', [CashReceiptController::class, 'edit']);
Route::patch('cash-receipts/{id}', [CashReceiptController::class, 'update']);
Route::get('cash-receipts/{id}/destroy', [CashReceiptController::class, 'destroy']);
Route::get('get_account_group_parties', [CashReceiptController::class, 'GetAccountGroupParties']);

Route::get('find-cash-payments/create', [FindCashPaymentController::class, 'create']);
Route::post('find-cash-payments', [FindCashPaymentController::class, 'store']);

Route::get('find-cash-receipts/create', [FindCashReceiptController::class, 'create']);
Route::post('find-cash-receipts', [FindCashReceiptController::class, 'store']);


Route::get('bank-receipts', [BankReceiptController::class, 'index']);
Route::get('bank-receipts/{id}/edit', [BankReceiptController::class, 'edit']);
Route::patch('bank-receipts/{id}', [BankReceiptController::class, 'update']);
Route::get('bank-receipts/{id}/destroy', [BankReceiptController::class, 'destroy']);

Route::get('general-voucher', [GeneralVoucherController::class, 'index']);
Route::get('general-voucher/{id}/edit', [GeneralVoucherController::class, 'edit']);
Route::patch('general-voucher/{id}', [GeneralVoucherController::class, 'update']);
Route::get('general-voucher/{id}/destroy', [GeneralVoucherController::class, 'destroy']);
//Route::resource('general-voucher', GeneralVoucherController::class);
Route::get('general-voucher/create', [GeneralVoucherController::class, 'create']);
Route::get('general-voucher/{id}', [GeneralVoucherController::class, 'show']);
Route::post('general-voucher', [GeneralVoucherController::class, 'store']);
//Route::get('general-voucher/{id}/destroy', [GeneralVoucherController::class,'destroy]);
Route::post('general-voucher/report', [GeneralVoucherController::class, 'report']);

Route::get('bank-payments', [BankPaymentController::class, 'index']);
Route::get('bank-payments/{id}/edit', [BankPaymentController::class, 'edit']);
Route::patch('bank-payments/{id}', [BankPaymentController::class, 'update']);
Route::get('bank-payments/{id}/destroy', [BankPaymentController::class, 'destroy']);

//Route::resource('opening-stock', OpeningStockController::class);
Route::get('opening-stock/search-products', [OpeningStockController::class, 'searchProductsAjax']);
Route::get('opening-stock/create', [OpeningStockController::class, 'create']);
Route::get('opening-stock/{id}', [OpeningStockController::class, 'show']);
Route::post('opening-stock', [OpeningStockController::class, 'store']);
Route::get('opening-stock', [OpeningStockController::class, 'index']);
Route::get('opening-stock/{id}/edit', [OpeningStockController::class, 'edit']);
Route::patch('opening-stock/{id}', [OpeningStockController::class, 'update']);
Route::get('opening-stock/{id}/destroy', [OpeningStockController::class, 'destroy']);

Route::resource('account-group', AccountGroupController::class);
Route::get('account-group/{id}/destroy', [AccountGroupController::class, 'destroy']);


Route::get('production', [ProductionController::class, 'index']);
Route::get('production/{id}/edit', [ProductionController::class, 'edit']);
Route::patch('production/{id}', [ProductionController::class, 'update']);
Route::get('production/{id}/destroy', [ProductionController::class, 'destroy']);

Route::get('stock-transfer', [StockTransferController::class, 'index']);
Route::get('stock-transfer/{id}/edit', [StockTransferController::class, 'edit']);
Route::patch('stock-transfer/{id}', [StockTransferController::class, 'update']);
Route::get('stock-transfer/{id}/destroy', [StockTransferController::class, 'destroy']);

Route::get('rawmaterial-to-salepoint', [RawMaterialToSalePointController::class, 'index']);
Route::get('rawmaterial-to-salepoint/{id}/edit', [RawMaterialToSalePointController::class, 'edit']);
Route::patch('rawmaterial-to-salepoint/{id}', [RawMaterialToSalePointController::class, 'update']);
Route::get('rawmaterial-to-salepoint/{id}/destroy', [RawMaterialToSalePointController::class, 'destroy']);


Route::resource('product-rates', ProductRateController::class);
Route::get('product-rates/{id}/destroy', [ProductRateController::class, 'destroy']);

//warehouses
Route::resource('warehouses', WarehouseController::class);
Route::get('warehouses/{id}/destroy', [WarehouseController::class, 'destroy']);


//banks
Route::resource('banks', BanksController::class);
Route::get('banks/{id}/destroy', [BanksController::class, 'destroy']);

//Account Group



//Catagory
Route::resource('catagories', CatagoryController::class);
Route::get('catagories/{id}/destroy', [CatagoryController::class, 'destroy']);
Route::get('catagories/importExcel/create', [CatagoryController::class, 'createImportExcel']);
Route::post('catagories/importExcel', [CatagoryController::class, 'ImportExcel']);

//Tax
Route::resource('ratings', RatingController::class);
Route::get('ratings/{id}/destroy', [RatingController::class, 'destroy']);
Route::resource('clients', ClientsController::class);
Route::get('clients/{id}/destroy', [ClientsController::class, 'destroy']);
Route::resource('taxes', TaxController::class);
Route::get('taxes/{id}/destroy', [TaxController::class, 'destroy']);
Route::resource('scenarios', ScenarioController::class);
Route::get('scenarios/{id}/destroy', [ScenarioController::class, 'destroy']);
Route::resource('partners', PartnersController::class);
Route::get('partners/{id}/destroy', [PartnersController::class, 'destroy']);

Route::resource('sro-schedules', SROScheduleController::class);
Route::get('sro-schedules/{id}/destroy', [SROScheduleController::class, 'destroy']);
Route::resource('sro-items', SROItemnoController::class);
Route::get('sro-items/{id}/destroy', [SROItemnoController::class, 'destroy']);
Route::get('sro-item/getsroitem/scenarion', [SROItemnoController::class, 'getsro_schedule']);

//Purchase Return
Route::resource('purchase-return', PurchaseReturnController::class);
Route::get('purchase-return/print/{id}', [PurchaseReturnController::class, 'print_purchase']);
Route::get('purchase-return/{id}/destroy', [PurchaseReturnController::class, 'destroy']);

//Sale Return
Route::resource('sales-return', SaleReturnController::class);
Route::get('sales-return/print/{id}', [SaleReturnController::class, 'print_sale']);
Route::get('sales-return/{id}/destroy', [SaleReturnController::class, 'destroy']);


//Purchase Report
Route::get('purchase-report/create', [PurchaseReportController::class, 'create']);
Route::post('purchase-report', [PurchaseReportController::class, 'store']);
Route::get('purchase-report/print', [PurchaseReportController::class, 'print_purchase']);

//Single Party Purchase Report
Route::resource('single-party-purchase-report', SinglePartyPurchaseController::class);
Route::resource('all-party-purchase-report', AllPartyPurchaseController::class);


Route::get('sale-report/print', [SaleReportController::class, 'print_sale']);
Route::resource('sample-bills-report', SampleBillReportController::class);

//Saletax Report
Route::resource('salestax-report/all-party', SaleTaxReportController::class);
Route::get('salestax-report/single-party/add', [SaleTaxReportController::class, 'SingleParty']);
Route::post('salestax-report/single-party/add/report', [SaleTaxReportController::class, 'ShowSingleParty']);

Route::resource('purchasetax-report/all-party', PurchaseTaxReportController::class);
Route::get('purchasetax-report/single-party/add', [PurchaseTaxReportController::class, 'SingleParty']);
Route::post('purchasetax-report/single-party/add/report', [PurchaseTaxReportController::class, 'ShowSingleParty']);
//Stock Report
Route::get('stock-report/all-items', [StockReportController::class, 'AllItems']);
//Stock Issue
Route::resource('stock-issue', StockIssueController::class);
Route::get('stock-issue/print/{id}', [StockIssueController::class, 'print_purchase']);
Route::get('stock-issue/{id}/destroy', [StockIssueController::class, 'destroy']);
//Stock Issue Report
Route::get('stockissue-report/create', [StockIssueReportController::class, 'index']);
Route::post('stockissue-report/print-report', [StockIssueReportController::class, 'print_report']);
//Expense Report
Route::resource('expense-report', ExpenseReportController::class);
/////////////////////////////ADMIN MIDDLEWARE ENDS////////////////////////////////////////


//Publisher

Route::resource('publisher', PublisherController::class);
Route::get('publisher/print', [PublisherController::class, 'print_publisher']);
Route::get('publisher/{id}/destroy', [PublisherController::class, 'destroy']);

//JS graph
//Yearly Sale/Purchase
Route::get('reports', [ReportsController::class, 'index']);
//Monthly Sale/Purchase
Route::get('reports/month', [ReportsController::class, 'month']);
//Daily Sale/Purchase
Route::get('reports/day', [ReportsController::class, 'days']);
Route::get('reports/expense', [ReportsController::class, 'expensemonth']);

//LC
Route::resource('lc-account', LCAccountController::class);
Route::get('lc-account/{id}/destroy', [LCAccountController::class, 'destroy']);

Route::resource('lc-info', LCInformationController::class);
Route::get('lc-info/{id}/destroy', [LCInformationController::class, 'destroy']);


Route::resource('lc-expense', LCExpenseController::class);
Route::get('lc-info/{id}/destroy', [LCExpenseController::class, 'destroy']);

Route::resource('lc-payment', LCPaymentController::class);
Route::get('lc-payment/{id}/destroy', [LCPaymentController::class, 'destroy']);


Route::resource('lc-approved', LCApprovedController::class);
Route::get('lc-approved/{id}/destroy', [LCApprovedController::class, 'destroy']);

Route::resource('indentor-info', LCIndentorController::class);
Route::get('indentor-info/{id}/destroy', [LCIndentorController::class, 'destroy']);

Route::resource('lc-location', LCLocationController::class);
Route::get('lc-location/{id}/destroy', [LCLocationController::class, 'destroy']);

Route::resource('lc-activity-report', LCReportController::class);

Route::resource('employees', EmployeeController::class);
Route::get('employees/{id}/destroy', [EmployeeController::class, 'destroy']);

Route::resource('appointments', AppointmentController::class);
Route::get('appointments/{id}/destroy', [AppointmentController::class, 'destroy']);

Route::resource('attendance', AttendanceController::class);
Route::resource('attendance-report', AttendanceReportController::class);

Route::get('/salary-sheet', [SalarySheetController::class, 'index']);
Route::post('/salary-sheet/find-report', [SalarySheetController::class, 'findReport']);

Route::get('/print-reports/create', [PrintReportsController::class, 'create']);
Route::post('/print-reports/find-report', [PrintReportsController::class, 'findReport']);

Route::get('product-report', [ProductReportController::class, 'index']);
Route::post('product-report/print', [ProductReportController::class, 'report']);