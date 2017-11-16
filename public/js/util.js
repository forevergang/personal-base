
if (typeof $jf === 'undefined') {
  var $jf = {};
}

(function($, _this){
  // get config for pc
  _this.getConfig = function(){

    if ('undefined' !==typeof $CONFIG) {
      return $CONFIG;
    }

    return null;
  };

  // get config
  _this.getMobileConfig = function(){

    if ('undefined' !==typeof $jf_m_config) {
      return $jf_m_config;
    }

    return null;
  };

  // check phone number for china
  _this.isMobile = function(value){
    // return /^1[3|5|7|8][0-9]\d{4,8}$/.test(value);
    return /^[1][3,4,5,7,8][0-9]{9}$/.test(value);
  };

  // check password
  _this.isPasswd = function(value){
    return value.match("^[0-9a-zA-Z][\A-Za-z0-9\!\*\.\_]{5,19}$");
  };

  // check bankcard for china
  _this.isBankCard = function(value){
    console.log(value);
  };

  // check recharge/withdrawal amount
  _this.isAmount = function(value){
    return /^\d+(\.\d{1,2}){0,1}$/g.test(value);
  };

  // check check openAccount chineseName
  _this.isChineseName = function(value){
    return /^[.\u4e00-\u9fa5]+$/.test(value);
  };

  // check openAccount IdcardNo
  _this.isIdCardNo = function(num) {
    var factorArr = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1);
    var parityBit = new Array("1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2");
    var varArray = new Array();
    var intValue;
    var lngProduct = 0;
    var intCheckDigit;
    var intStrLen = num.length;
    var idNumber = num;
    // initialize
    if ((intStrLen != 15) && (intStrLen != 18)) {
      return false;
    }
    // check and set value
    for (i = 0; i < intStrLen; i++) {
      varArray[i] = idNumber.charAt(i);
      if ((varArray[i] < '0' || varArray[i] > '9') && (i != 17)) {
        return false;
      } else if (i < 17) {
        varArray[i] = varArray[i] * factorArr[i];
      }
    }

    if (intStrLen == 18) {
      //check date
      var date8 = idNumber.substring(6, 14);
      if (isDate8(date8) == false) {
        return false;
      }
      // calculate the sum of the products
      for (i = 0; i < 17; i++) {
        lngProduct = lngProduct + varArray[i];
      }
      // calculate the check digit
      intCheckDigit = parityBit[lngProduct % 11];
      // check last digit
      if (varArray[17] != intCheckDigit) {
        return false;
      }
    }
    else {        //length is 15
      //check date
      var date6 = idNumber.substring(6, 12);
      if (isDate6(date6) == false) {
        return false;
      }
    }
    return true;
  };

  function isDate6(sDate) {
    if (!/^[0-9]{6}$/.test(sDate)) {
      return false;
    }
    var year, month, day;
    year = sDate.substring(0, 4);
    month = sDate.substring(4, 6);
    if (year < 1700 || year > 2500) {return false;}
    if (month < 1 || month > 12) {return false;}
    return true;
  }

  function isDate8(sDate) {
    if (!/^[0-9]{8}$/.test(sDate)) {
      return false;
    }
    var year, month, day;
    year = sDate.substring(0, 4);
    month = sDate.substring(4, 6);
    day = sDate.substring(6, 8);
    var iaMonthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]
    if (year < 1700 || year > 2500) {return false;}
    if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)) iaMonthDays[1] = 29;
    if (month < 1 || month > 12) {return false;}
    if (day < 1 || day > iaMonthDays[month - 1]) {return false;}
    return true;
  }

})(jQuery, $jf.util = $jf.util || {});

