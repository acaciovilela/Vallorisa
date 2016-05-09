var BASE_PATH = "";

$(document).ready(function () {
    $(':input').attr('placeholder', '');
});

function fetchAddressByCep(e) {
    var t = e.replace(".", "");
    var n = t.replace("-", "");
    var r = n.replace("_", "");
    if (r.length === 8) {
        var i = "http://api.geonames.org/postalCodeLookupJSON";
        var s = $(".city");
        var o = $(".state");
        var u = $(".country");
        $.ajax({url: i, dataType: "JSONP", data: {country: "BR", username: "acaciovilela", postalcode: r}, success: function (e) {
                $.map(e.postalcodes, function (e) {
                    s.val(e.placeName.toUpperCase());
                    o.val(e.adminName1.toUpperCase());
                    u.val(e.countryCode);
                });
            }});
    }
}

function disableOff(e) {
    if ("INTEGRATED" === e) {
        $("#show-on-integrating").attr('class', 'show');
        $("#show-on-aproving").attr('class', 'hidden');
    } else if ("APPROVED" === e) {
        $("#show-on-aproving").attr('class', 'show');
        $("#show-on-integrating").attr('class', 'hidden');
    } else {
        $("#show-on-integrating").attr('class', 'hidden');
        $("#show-on-aproving").attr('class', 'hidden');
    }
}

function calculateProposalValue(inValue) {
    if (inValue) {
        var url = BASE_PATH + "/admin/proposal/vehicle-proposal/1/calculateValue";
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'post',
            data: {
                inValue: inValue,
                totalValue: $('#vehicleProposalTotalValue').val()
            },
            success: function (data) {
                $('#proposalValue').val(data.value);
            }
        });
    }
}

function calculateRealtyProposalValue(inValue) {
    if (inValue) {
        var url = BASE_PATH + "/admin/proposal/realty-proposal/1/calculate";
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'post',
            data: {
                inValue: inValue,
                totalValue: $('#realtyProposalTotalValue').val()
            },
            success: function (data) {
                $('#proposalValue').val(data.value);
            }
        });
    }
}

function calculateProposal(e, t) {
    if (e) {
        var n = BASE_PATH + "/admin/proposal/proposal/calculate";
        $.ajax({
            dataType: "JSON",
            url: n, data: {
                parcelAmount: e,
                proposalValue: $("#proposalValue").val(),
                proposalTotalValue: $("#realtyProposalTotalValue").val()},
            success: function (e) {
                $("#proposalEndDate").val(e.result.endDate);
                $("#proposalStartDate").val(e.result.startDate);
                $("#realtyProposalInValue").val(e.result.inValue);
            }
        });
    }
}

function setMasks() {
//    $(".cpf").mask("999.999.999-99");
//    $(".cnpj").mask("99.999.999/9999-99");
//    $(".cep").mask("99.999-999");
//    $(".phone").mask("(99) 9999-9999");
//    $(".validity").mask("99/99");
//    $(".creditcard").mask("9999-9999-9999-9999");
//    $(".porcent").priceFormat({prefix: "", thousandsSeparator: "", centsSeparator: ",", limit: 5});
//    $(".currency").priceFormat({prefix: "", thousandsSeparator: ".", centsSeparator: ","});
}

/*SET MASK TO TEXT INPUT ******************************************************/
$(document).ready(function () {
    $('.date').mask('11/11/1111', {clearIfNotMatch: true});
    $('.time').mask('00:00:00', {clearIfNotMatch: true});
    $('.cep').mask('00.000-000', {clearIfNotMatch: true});
    $('.phone').mask('(00) 0000-0000', {clearIfNotMatch: true});
    $('.cpf').mask('000.000.000-00', {reverse: true, clearIfNotMatch: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true, clearIfNotMatch: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true, clearIfNotMatch: true});
    $('.creditcard').mask('0000 0000 0000 0000', {reverse: true, clearIfNotMatch: true});
    $('.validity').mask('00/00', {reverse: true, clearIfNotMatch: true});
    $('.currency').mask("#.##0,00", {reverse: true, maxlength: false, clearIfNotMatch: true});
    $('.porcent').mask('##0,00%', {reverse: true, clearIfNotMatch: true});
    $('.decimals').mask('##0,00', {reverse: true, clearIfNotMatch: true});
});

function calculatePrice(e, t, n) {
    var r = e;
    var i = t;
    var s = r.replace("R$ ", "");
    var o = s.replace(".", "");
    var u = o.replace(",", ".");
    var a = i.replace("R$ ", "");
    var f = a.replace(".", "");
    var l = f.replace(",", ".");
    var c = BASE_PATH + "/admin/avr/price";
    $.ajax({url: c, dataType: "JSON", data: {cost: u, markup: l}, success: function (e) {
            n.val(e.price);
        }});
}

function addProduct(e) {
    var t = $("#quantity").val();
    $.ajax({url: BASE_PATH + "/admin/business/sale/addproduct", dataType: "JSON", data: {product: e, quantity: t}, success: function (e) {
            if (e.result === true) {
                $("#productList").load(BASE_PATH + "/admin/business/sale/listproducts");
                $("#quantity").val(1);
                calculateSale();
            }
        }, error: function (e) {
            console.log(e);
        }});
}

function calculateSale() {
    var e = $("#orderAddition");
    var t = $("#orderDiscount");
    var n = $("#orderTotal");
    $.ajax({url: BASE_PATH + "/admin/business/sale/calculate", dataType: "JSON", data: {addition: e.val(), discount: t.val()}, success: function (e) {
            n.val(e.result);
        }, error: function (e) {
            console.log(e);
        }});
}

function updateProduct(e) {
    var t = $("#productQuantity" + e).val();
    $.ajax({url: BASE_PATH + "/admin/business/sale/updateproduct", dataType: "JSON", data: {quantity: t, item: e}, success: function (e) {
            if (e.result) {
                $("#productList").load(BASE_PATH + "/admin/business/sale/listproducts");
                calculateSale();
            }
        }, error: function (e) {
            console.log(e);
        }});
}

function fillSelect(e, t, n) {
    var r = t;
    var i = $("#" + n);
    $.ajax({url: r, dataType: "JSON", data: {itemId: e}, beforeSend: function () {
            i.empty();
            i.append('<option value="">Carregando...</option>');
        }, success: function (e) {
            i.empty();
            i.append('<option value="">Selecione</option>');
            i.append(e.options);
            return true;
        }});
}

function vehicleTypeList(e) {
    if (e) {
        $(".vehicle-type-list").load(BASE_PATH + "/admin/vehicle/vehicle-type/list/" + e);
    } else {
        $(".vehicle-type-list").empty();
    }
    $("#vehicle_type_name").val("");
    $("#vehicle_type_name").focus();
}

function vehicleTypePost() {
    var e = BASE_PATH + "/admin/vehicle/vehicle-type/post";
    $.ajax({url: e, dataType: "JSON", data: {vehicle_brand_id: $("#vehicle_brand_id").val(), vehicle_type_name: $("#vehicle_type_name").val()}, success: function (e) {
            vehicleTypeList($("#vehicle_brand_id").val());
        }});
}

function vehicleTypeDelete(e, t) {
    var n = BASE_PATH + "/admin/vehicle/vehicle-type/delete";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, data: {vehicle_type_id: e}, dataType: "JSON", success: function (e) {
                if (e.result === true) {
                    vehicleTypeList(t);
                }
            }});
    } else {
        return void 0;
    }
}

function vehicleModelList(e) {
    if (e) {
        $(".vehicle-model-list").load(BASE_PATH + "/admin/vehicle/vehicle-model/list/" + e);
    } else {
        $(".vehicle-model-list").empty();
    }
    $("#vehicle_model_name").val("");
    $("#vehicle_model_name").focus();
}

function vehicleModelPost() {
    var e = BASE_PATH + "/admin/vehicle/vehicle-model/post";
    $.ajax({url: e, dataType: "JSON", data: {vehicle_type_id: $("#vehicle_type_id").val(), vehicle_model_name: $("#vehicle_model_name").val()}, success: function (e) {
            vehicleModelList($("#vehicle_type_id").val());
        }});
}

function vehicleModelDelete(e, t) {
    var n = BASE_PATH + "/admin/vehicle/vehicle-model/delete";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, data: {vehicle_model_id: e}, dataType: "JSON", success: function (e) {
                if (e.result === true) {
                    vehicleModelList(t);
                }
            }});
    } else {
        return void 0;
    }
}

function vehicleVersionList(e) {
    if (e) {
        $(".vehicle-version-list").load(BASE_PATH + "/admin/vehicle/vehicle-version/list/" + e);
    } else {
        $(".vehicle-version-list").empty();
    }
    $("#vehicle_model_name").val("");
    $("#vehicle_model_name").focus();
}

function vehicleVersionPost() {
    var e = BASE_PATH + "/admin/vehicle/vehicle-version/post";
    $.ajax({url: e, dataType: "JSON", data: {vehicle_model_id: $("#vehicle_model_id").val(), vehicle_version_name: $("#vehicle_version_name").val()}, success: function () {
            vehicleVersionList($("#vehicle_model_id").val());
        }});
}
function vehicleVersionDelete(e, t) {
    var n = BASE_PATH + "/admin/vehicle/vehicle-version/delete";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, data: {vehicle_version_id: e}, dataType: "JSON", success: function (e) {
                if (e.result === true) {
                    vehicleVersionList(t);
                }
            }});
    } else {
        return void 0;
    }
}
function customerPatrimonyList(e) {
    $(".customer-patrimony-list").load(BASE_PATH + "/admin/customer/1/customer-patrimony/list/" + e);
}
function customerPatrimonyPost() {
    var e = BASE_PATH + "/admin/customer/1/customer-patrimony/post";
    $.ajax({url: e, dataType: "JSON", data: {customer_id: $("#customer_id").val(), patrimony_name: $("#patrimony_name").val(), patrimony_value: $("#patrimony_value").val()}, success: function () {
            customerPatrimonyList($("#customer_id").val());
        }});
}

function customerPatrimonyDelete(e, t) {
    var n = BASE_PATH + "/admin/customer/1/customer-patrimony/delete";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {patrimony_id: e}, success: function (e) {
                if (e.result === true) {
                    customerPatrimonyList(t);
                }
            }});
    } else {
        return void 0;
    }
}

function customerVehicleList(e) {
    $(".customer-vehicle-list").load(BASE_PATH + "/admin/customer/1/customer-vehicle/list/" + e);
}

function customerVehiclePost() {
    var e = BASE_PATH + "/admin/customer/1/customer-vehicle/post";
    $.ajax({url: e, dataType: "JSON", data: {customerId: $("#customer_id").val(), vehicleYear: $("#customerVehicleYear").val(), vehicleYearModel: $("#customerVehicleYearModel").val(), vehiclePlate: $("#customerVehiclePlate").val(), vehicleValue: $("#customerVehicleValue").val(), vehicleColor: $("#customerVehicleColor").val(), vehicleBrandId: $("#customerVehicleBrandId").val(), vehicleTypeId: $("#customerVehicleTypeId").val(), vehicleModelId: $("#customerVehicleModelId").val(), vehicleVersionId: $("#customerVehicleVersionId").val()}, success: function () {
            customerVehicleList($("#customer_id").val());
        }});
}

function customerVehicleDelete(e, t) {
    var n = BASE_PATH + "/admin/customer/1/customer-vehicle/delete";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {vehicleId: e}, success: function (e) {
                if (e.result === true) {
                    customerVehicleList(t);
                }
            }});
    } else {
        return void 0;
    }
}

function customerBankAccountList(e) {
    $(".customer-bank-account-list").load(BASE_PATH + "/admin/customer/1/customer-bank-account/list/" + e);
}

function customerBankAccountPost() {
    var e = BASE_PATH + "/admin/customer/1/customer-bank-account/post";
    $.ajax({url: e, dataType: "JSON", data: {customer_id: $("#customer_id").val(), bank_account_id: null, bank_account_type: $("#bank_account_type").val(), bank_account_bank: $("#bank_account_bank").val(), bank_account_agency: $("#bank_account_agency").val(), bank_account_account: $("#bank_account_account").val(), bank_account_since: $("#bank_account_since").val(), bank: $("#bank").val()}, success: function () {
            customerBankAccountList($("#customer_id").val());
        }});
}

function customerBankAccountDelete(e, t) {
    var n = BASE_PATH + "/admin/customer/1/customer-bank-account/delete";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {bank_account_id: e}, success: function (e) {
                if (e.result === true) {
                    customerBankAccountList(t);
                }
            }});
    } else {
        return void 0;
    }
}

function customerReferenceList(e) {
    $(".customer-reference-list").load(BASE_PATH + "/admin/customer/1/customer-reference/list/" + e);
}

function customerReferencePost() {
    var e = BASE_PATH + "/admin/customer/1/customer-reference/post";
    $.ajax({url: e, dataType: "JSON", data: {customer_id: $("#customer_id").val(), reference_type: $("#reference_type").val(), reference_name: $("#reference_name").val(), reference_phone: $("#reference_phone").val()}, success: function () {
            customerReferenceList($("#customer_id").val());
        }});
}

function customerReferenceDelete(e, t) {
    var n = BASE_PATH + "/admin/customer/1/customer-reference/delete";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {reference_id: e}, success: function (e) {
                if (e.result === true) {
                    customerReferenceList(t);
                }
            }});
    } else {
        return void 0;
    }
}

function vehicleProposalList() {
    $(".vehicle-proposal-list").load(BASE_PATH + "/admin/proposal/vehicle-proposal/1/listvehicles");
}

function vehicleProposalAdd() {
    var e = BASE_PATH + "/admin/proposal/vehicle-proposal/1/addvehicle";
    $.ajax({url: e, dataType: "JSON", data: {vehicleId: null, vehicleBrandId: $("#vehicleBrandId").val(), vehicleTypeId: $("#vehicleTypeId").val(), vehicleModelId: $("#vehicleModelId").val(), vehicleVersionId: $("#vehicleVersionId").val(), vehicleYear: $("#vehicleYear").val(), vehicleYearModel: $("#vehicleYearModel").val(), vehiclePlate: $("#vehiclePlate").val(), vehiclePlateUf: $("#vehiclePlateUf").val(), vehicleColor: $("#vehicleColor").val(), vehicleStatus: $("#vehicleStatus").val(), vehicleValue: $("#vehicleValue").val(), vehicleFuel: $("#vehicleFuel").val(), vehicleOwnerType: $("#vehicleOwnerType").val(), vehicleFrame: $("#vehicleFrame").val(), vehicleRenavam: $("#vehicleRenavam").val(), vehicleLicenceUf: $("#vehicleLicenceUf").val(), vehicleNotes: $("#vehicleNotes").val()}, success: function () {
            vehicleProposalList();
        }});
}

function vehicleProposalDelete(e) {
    var t = BASE_PATH + "/admin/proposal/vehicle-proposal/1/deletevehicle";
    var n = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (n) {
        $.ajax({url: t, dataType: "JSON", data: {itemId: e}, success: function (t) {
                if (t.result === true) {
                    vehicleProposalList(e);
                }
            }});
    } else {
        return void 0;
    }
}

function proposalCustomerBankAccountList() {
    $(".proposal-customer-bank-account-list").load(BASE_PATH + "/admin/proposal/proposal/listcustomerbankaccount");
}

function proposalCustomerBankAccountAdd() {
    var e = BASE_PATH + "/admin/proposal/proposal/addcustomerbankaccount";
    $.ajax({
        url: e,
        dataType: "JSON",
        data: {
            id: null,
            bankName: $("#bank_account_bank").val(),
            type: $("#bank_account_type").val(),
            agency: $("#bank_account_agency").val(),
            account: $("#bank_account_account").val(),
            since: $("#bank_account_since").val(),
            bank: $("#bank").val()
        }, success: function () {
            proposalCustomerBankAccountList();
        }});
}

function proposalCustomerBankAccountDelete(e, t) {
    var n = BASE_PATH + "/admin/proposal/proposal/deletecustomerbankaccount";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {itemId: e, dataId: t}, success: function (t) {
                if (t.result === true) {
                    proposalCustomerBankAccountList(e);
                }
            }});
    } else {
        return void 0;
    }
}

function proposalCustomerReferenceList() {
    $(".proposal-customer-reference-list").load(BASE_PATH + "/admin/proposal/proposal/listcustomerreference");
}

function proposalCustomerReferenceAdd() {
    var e = BASE_PATH + "/admin/proposal/proposal/addcustomerreference";
    $.ajax({url: e, dataType: "JSON", data: {id: null, type: $("#reference_type").val(), name: $("#reference_name").val(), phone: $("#reference_phone").val()}, success: function () {
            proposalCustomerReferenceList();
        }});
}

function proposalCustomerReferenceDelete(e, t) {
    var n = BASE_PATH + "/admin/proposal/proposal/deletecustomerreference";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {itemId: e, dataId: t}, success: function (t) {
                if (t.result === true) {
                    proposalCustomerReferenceList(e);
                }
            }});
    } else {
        return void 0;
    }
}

function proposalCustomerPatrimonyList() {
    $(".proposal-customer-patrimony-list").load(BASE_PATH + "/admin/proposal/proposal/listcustomerpatrimony");
}

function proposalCustomerPatrimonyAdd() {
    var e = BASE_PATH + "/admin/proposal/proposal/addcustomerpatrimony";
    $.ajax({url: e, dataType: "JSON", data: {id: null, name: $("#patrimony_name").val(), value: $("#patrimony_value").val(), debit: $("#patrimony_debit").val()}, success: function () {
            proposalCustomerPatrimonyList();
        }});
}

function proposalCustomerPatrimonyDelete(e, t) {
    var n = BASE_PATH + "/admin/proposal/proposal/deletecustomerpatrimony";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {itemId: e, dataId: t}, success: function (t) {
                if (t.result === true) {
                    proposalCustomerPatrimonyList(e);
                }
            }});
    } else {
        return void 0;
    }
}

function proposalCustomerVehicleList() {
    $(".proposal-customer-vehicle-list").load(BASE_PATH + "/admin/proposal/proposal/listcustomervehicle");
}
function proposalCustomerVehicleAdd() {
    var e = BASE_PATH + "/admin/proposal/proposal/addcustomervehicle";
    $.ajax({url: e, dataType: "JSON", data: {id: null, brand: $("#customerVehicleBrandId").val(), type: $("#customerVehicleTypeId").val(), model: $("#customerVehicleModelId").val(), version: $("#customerVehicleVersionId").val(), year: $("#customerVehicleYear").val(), yearModel: $("#customerVehicleYearModel").val(), plate: $("#customerVehiclePlate").val(), color: $("#customerVehicleColor").val(), value: $("#customerVehicleValue").val()}, success: function () {
            proposalCustomerVehicleList();
        }});
}

function proposalCustomerVehicleDelete(e, t) {
    var n = BASE_PATH + "/admin/proposal/proposal/deletecustomervehicle";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {itemId: e, dataId: t}, success: function (t) {
                if (t.result === true) {
                    proposalCustomerVehicleList(e);
                }
            }});
    } else {
        return void 0;
    }
}

function realtyProposalList() {
    $(".realty-proposal-list").load(BASE_PATH + "/admin/proposal/realty-proposal/1/listrealties");
}

function realtyProposalAdd() {
    var e = BASE_PATH + "/admin/proposal/realty-proposal/1/addrealty";
    $.ajax({type: "POST", url: e, dataType: "JSON", data: {realtyType: $("#realtyType").val(), realtyValue: $("#realtyValue").val(), addressName: $("#realtyAddressName").val(), addressNumber: $("#realtyAddressNumber").val(), addressComplement: $("#realtyAddressComplement").val(), addressQuarter: $("#realtyAddressQuarter").val(), addressCep: $("#realtyAddressCep").val(), addressCity: $("#realtyAddressCity").val(), addressState: $("#realtyAddressState").val(), addressCountry: $("#realtyAddressCountry").val(), realtyFeatureBuiltArea: $(".realtyFeatureBuiltArea").val(), realtyFeatureBalconyArea: $(".realtyFeatureBalconyArea").val(), realtyFeatureTotalArea: $(".realtyFeatureTotalArea").val(), realtyFeatureUsefulArea: $(".realtyFeatureUsefulArea").val(), realtyFeatureGroundArea: $(".realtyFeatureGroundArea").val(), realtyFeatureGroundWidth: $(".realtyFeatureGroundWidth").val(), realtyFeatureGroundLength: $(".realtyFeatureGroundLength").val(), realtyFeatureBedroomAmount: $(".realtyFeatureBedroomAmount").val(), realtyFeatureRoomAmount: $(".realtyFeatureRoomAmount").val(), realtyFeatureSuiteAmount: $(".realtyFeatureSuiteAmount").val(), realtyFeatureBathtubAmount: $(".realtyFeatureBathtubAmount").val(), realtyFeatureBathroomAmount: $(".realtyFeatureBathroomAmount").val(), realtyFeatureHallAmount: $(".realtyFeatureHallAmount").val(), realtyFeatureBathroomStall: $(".realtyFeatureBathroomStall").val(), realtyFeatureBathroomCabinet: $(".realtyFeatureBathroomCabinet").val(), realtyFeatureRoomCabinet: $(".realtyFeatureRoomCabinet").val(), realtyFeatureRestroom: $(".realtyFeatureRestroom").val(), realtyFeatureDoubleLiving: $(".realtyFeatureDoubleLiving").val(), realtyFeatureDiningRoom: $(".realtyFeatureDiningRoom").val(), realtyFeatureTvRoom: $(".realtyFeatureTvRoom").val(), realtyFeatureOffice: $(".realtyFeatureOffice").val(), realtyFeatureKitchen: $(".realtyFeatureKitchen").val(), realtyFeaturePlannedKitchen: $(".realtyFeaturePlannedKitchen").val(), realtyFeatureStoreRoom: $(".realtyFeatureStoreRoom").val(), realtyFeatureServiceArea: $(".realtyFeatureServiceArea").val(), realtyFeatureStoreHouse: $(".realtyFeatureStoreHouse").val(), realtyFeatureLiningSlab: $(".realtyFeatureLiningSlab").val(), realtyFeaturePvcLiner: $(".realtyFeaturePvcLiner").val(), realtyFeaturePlanking: $(".realtyFeaturePlanking").val(), realtyFeatureFinishPlaster: $(".realtyFeatureFinishPlaster").val(), realtyFeatureGasHeater: $(".realtyFeatureGasHeater").val(), realtyFeatureSolarHeater: $(".realtyFeatureSolarHeater").val()}, success: function () {
            realtyProposalList();
        }});
}

function realtyProposalDelete(e) {
    var t = BASE_PATH + "/admin/proposal/realty-proposal/1/deleterealty";
    var n = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (n) {
        $.ajax({url: t, dataType: "JSON", data: {itemId: e}, success: function (t) {
                if (t.result === true) {
                    realtyProposalList(e);
                }
            }});
    } else {
        return void 0;
    }
}

function caixaProposalList() {
    $(".caixa-proposal-list").load(BASE_PATH + "/admin/proposal/caixa-proposal/1/listproducts");
}

function caixaProposalAdd() {
    var e = BASE_PATH + "/admin/proposal/caixa-proposal/1/addproduct";
    $.ajax({type: "GET", url: e, dataType: "JSON", data: {product: $("#productId").val()}, success: function () {
            caixaProposalList();
        }});
}

function caixaProposalDelete(e) {
    var t = BASE_PATH + "/admin/proposal/caixa-proposal/1/deleteproduct";
    var n = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (n) {
        $.ajax({url: t, dataType: "JSON", data: {itemId: e}, success: function (t) {
                if (t.result === true) {
                    caixaProposalList(e);
                }
            }});
    } else {
        return void 0;
    }
}

function productList(e) {
    $(".product-list").load(BASE_PATH + "/admin/product/1/list?id=" + e);
}

function shopmanProductAdd() {
    var e = BASE_PATH + "/admin/shopman/1/shopman-product/1/add";
    $.ajax({type: "GET", url: e, dataType: "JSON", data: {product: $("#productId").val(), shopman: $("#shopmanId").val()}, success: function () {
            shopmanProductList($("#shopmanId").val());
        }});
}

function shopmanProductList(e) {
    $(".shopman-product-list").load(BASE_PATH + "/admin/shopman/1/shopman-product/1/list?shopman=" + e);
}

function shopmanProductDelete(e, t) {
    var n = BASE_PATH + "/admin/shopman/1/shopman-product/1/delete";
    var r = window.confirm("Deseja realmente apagar este item? Esta ação é irreversível.");
    if (r) {
        $.ajax({url: n, dataType: "JSON", data: {productId: t, shopmanId: e}, success: function (e) {
                if (e.result === true) {
                    shopmanProductList(e.shopmanId);
                }
            }});
    } else {
        return void 0;
    }
}

function calculateArea() {
    var e = $("#realtyFeatureBuiltArea").val();
    var t = $("#realtyFeatureBalconyArea").val();
    $.ajax({type: "GET", url: BASE_PATH + "/admin/realty-feature/calculatearea", dataType: "JSON", data: {built: e, balcony: t}, success: function (e) {
            $("#realtyFeatureTotalArea").empty();
            $("#realtyFeatureTotalArea").val(e.total);
        }});
    return true;
}

function calculateGround() {
    var e = $("#realtyFeatureGroundWidth").val();
    var t = $("#realtyFeatureGroundLength").val();
    $.ajax({type: "GET", url: BASE_PATH + "/admin/realty-feature/calculateground", dataType: "JSON", data: {width: e, length: t}, success: function (e) {
            $("#realtyFeatureGroundArea").empty();
            $("#realtyFeatureGroundArea").val(e.total);
        }});
    return true;
}

function changePerson(e) {
    if (e === "MA==") {
        $("#cpf").attr("style", "display:block;visibility:show;");
        $("#cnpj").attr("style", "display:none;visibility:hidden;");
        $(".cpf").attr("required", "required");
        $(".cnpj").removeAttr("required");
    } else if (e === "MQ==") {
        $("#cnpj").attr("style", "display:block;visibility:show;");
        $("#cpf").attr("style", "display:none;visibility:hidden;");
        $(".cnpj").attr("required", "required");
        $(".cpf").removeAttr("required");
    } else {
        alert(e);
        $("#personType").val("");
        $("#individualCpf").attr("style", "display:none;visibility:hidden;");
        $("#legalCnpj").attr("style", "display:none;visibility:hidden;");
    }
}

function addCommission() {
    var e = $(".add-commissions > fieldset > fieldset").length;
    var t = $(".add-commissions > fieldset > span").data("template");
    t = t.replace(/__index__/g, e);
    $(".add-commissions > fieldset").append(t);
    setMasks();
    return false;
}

function removeCommission() {
    var e = $(".add-commissions > fieldset > fieldset").last();
    e.remove();
    return false;
}

$(document).ready(function () {
    $(':text, textarea').on('keyup', function () {
        $(this).val($(this).val().toUpperCase());
    });
    setMasks();
});

//$(document).ready(function() {
//    $(this).ajaxSend(function() {
//        $('#pre-loading').modal();
//    });
//    $(this).ajaxComplete(function(){
//        $('#pre-loading').modal('hide');
//    });
//});

$('body').on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
});


$(function () {
    $('.datepicker').datetimepicker({
        locale: 'pt-br',
        format: 'L',
        useCurrent: false
    });
});