"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_src_pages_company_Admin_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/company/Admin.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/company/Admin.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw new Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw new Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'Detail',
  data: function data() {
    return {
      transactions: {},
      checkAllStatus: false
    };
  },
  mounted: function mounted() {
    var _this = this;
    if (!this.$store.state.permissions.includes('transaction_push_plugin')) {
      Swal.fire({
        position: 'top',
        icon: 'error',
        title: 'You don\'t have an access this page',
        showConfirmButton: false,
        timer: 3000
      }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _this.$router.push('/app/company/' + _this.$route.params.id + '/detail');
            case 1:
            case "end":
              return _context.stop();
          }
        }, _callee);
      })));
      return;
    }
    this.getData();
  },
  methods: {
    handleCheckItem: function handleCheckItem(key) {
      var transactionLocals = [];
      this.transactions.forEach(function (x, i) {
        transactionLocals.push(x);
        if (key === i) {
          transactionLocals[i].is_selected = x.is_selected === undefined ? true : !x.is_selected;
        }
      });
      this.transactions = transactionLocals;
      console.log("trans", this.transactions);
      this.checkAllStatus = false;
    },
    checkBoxAll: function checkBoxAll() {
      var _this2 = this;
      var transactionLocals = [];
      this.transactions.forEach(function (x, i) {
        transactionLocals.push(x);
        transactionLocals[i].is_selected = !_this2.checkAllStatus;
      });
      this.transactions = transactionLocals;
      console.log("trans", this.transactions);
    },
    getData: function getData() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var respDe;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.prev = 0;
              _this3.$vs.loading();
              _context2.next = 4;
              return _this3.$axios.get("api/transaction?company_id=".concat(_this3.$route.params.id));
            case 4:
              respDe = _context2.sent;
              _this3.$vs.loading.close();
              _this3.transactions = respDe;
              _context2.next = 13;
              break;
            case 9:
              _context2.prev = 9;
              _context2.t0 = _context2["catch"](0);
              _this3.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context2.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 13:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[0, 9]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/company/Admin.vue?vue&type=template&id=1b5d65d9":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/company/Admin.vue?vue&type=template&id=1b5d65d9 ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "container-fluid"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-title"
  }, [_c("h1", {
    staticClass: "h3 mt-3 ml-3 text-gray-800 float-left"
  }, [_vm._v("Company Admin Page")]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-success float-right mt-3 mr-3",
    attrs: {
      to: "/app/company"
    }
  }, [_c("i", {
    staticClass: "fa fa-arrow-left"
  }), _vm._v(" Back\n            ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _c("h3", {
    staticClass: "h3 text-gray-800 float-left mt-3"
  }, [_vm._v("Transaction Data")]), _vm._v(" "), _c("div", {
    staticClass: "table-responsive"
  }, [_c("table", {
    staticClass: "table table-bordered",
    attrs: {
      id: "dataTable",
      width: "100%",
      cellspacing: "0"
    }
  }, [_c("thead", [_c("tr", [_c("th", [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.checkAllStatus,
      expression: "checkAllStatus"
    }],
    attrs: {
      type: "checkbox"
    },
    domProps: {
      checked: Array.isArray(_vm.checkAllStatus) ? _vm._i(_vm.checkAllStatus, null) > -1 : _vm.checkAllStatus
    },
    on: {
      click: function click($event) {
        return _vm.checkBoxAll();
      },
      change: function change($event) {
        var $$a = _vm.checkAllStatus,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && (_vm.checkAllStatus = $$a.concat([$$v]));
          } else {
            $$i > -1 && (_vm.checkAllStatus = $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.checkAllStatus = $$c;
        }
      }
    }
  })]), _vm._v(" "), _c("th", [_vm._v("Transaction Number")]), _vm._v(" "), _c("th", [_vm._v("Author")]), _vm._v(" "), _c("th", [_vm._v("Company")]), _vm._v(" "), _c("th", [_vm._v("Method")]), _vm._v(" "), _c("th", [_vm._v("Project")]), _vm._v(" "), _c("th", [_vm._v("Title")]), _vm._v(" "), _c("th", [_vm._v("Last Status")]), _vm._v(" "), _c("th", [_vm._v("Total")]), _vm._v(" "), _c("th", [_vm._v("Created At")])])]), _vm._v(" "), _c("tbody", [_c("tr", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.transactions.length == 0,
      expression: "transactions.length == 0"
    }]
  }, [_c("td", {
    staticClass: "text-center",
    attrs: {
      colspan: "10"
    }
  }, [_vm._v("\n                            Empty Transactions\n                        ")])]), _vm._v(" "), _vm._l(_vm.transactions, function (transaction, key) {
    var _transaction$method;
    return _c("tr", [_c("td", [_c("input", {
      attrs: {
        type: "checkbox"
      },
      domProps: {
        checked: transaction.is_selected === undefined ? false : transaction.is_selected
      },
      on: {
        click: function click($event) {
          return _vm.handleCheckItem(key);
        }
      }
    })]), _vm._v(" "), _c("td", [_c("router-link", {
      attrs: {
        to: "/app/transaction/" + transaction.id + "/detail"
      }
    }, [_vm._v("\n                                " + _vm._s(transaction.transaction_number) + "\n                            ")])], 1), _vm._v(" "), _c("td", [_vm._v(_vm._s(transaction.user_created_by.name))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(transaction.project.company.title))]), _vm._v(" "), _c("td", [_c("span", {
      staticClass: "badge rounded-pill text-bg-primary"
    }, [_vm._v(_vm._s((_transaction$method = transaction.method) !== null && _transaction$method !== void 0 ? _transaction$method : "-"))])]), _vm._v(" "), _c("td", [_c("span", {
      staticClass: "badge rounded-pill text-bg-warning"
    }, [_vm._v(_vm._s(transaction.project.title))])]), _vm._v(" "), _c("td", [_vm._v(_vm._s(transaction.title))]), _vm._v(" "), _c("td", [_c("span", {
      staticClass: "badge rounded-pill text-bg-primary"
    }, [_vm._v(_vm._s(transaction.current_status))])]), _vm._v(" "), _c("td", [_vm._v("Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(transaction.total_amount)))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm._f("formatDate")(transaction.created_at)))])]);
  })], 2)])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-6"
  }), _vm._v(" "), _c("div", {
    staticClass: "col-6"
  })]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-lg-12"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-4"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body shadow-lg"
  }, [_c("h5", {
    staticClass: "card-title"
  }, [_vm._v("Total Manual Transfer")]), _vm._v(" "), _c("div", {
    staticClass: "d-flex flex-column"
  }, [_c("span", [_vm._v("\n                                            Rp. 0\n                                        ")]), _vm._v(" "), _c("span", [_vm._v("\n                                            0 Transaction\n                                        ")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-4"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body shadow-lg"
  }, [_c("h5", {
    staticClass: "card-title"
  }, [_vm._v("Total By Plugin Flip")]), _vm._v(" "), _c("div", {
    staticClass: "d-flex flex-column"
  }, [_c("span", [_vm._v("\n                                            Rp. 0\n                                        ")]), _vm._v(" "), _c("span", [_vm._v("\n                                            0 Transaction\n                                        ")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-4"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-body shadow-lg"
  }, [_c("h5", {
    staticClass: "card-title"
  }, [_vm._v("Flip Balance")]), _vm._v(" "), _c("div", {
    staticClass: "d-flex flex-column"
  }, [_c("span", [_vm._v("\n                                            Rp. 0\n                                        ")]), _vm._v(" "), _c("span", [_vm._v("\n                                            Plugin\n                                        ")])])])])])])])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/src/pages/company/Admin.vue":
/*!**************************************************!*\
  !*** ./resources/js/src/pages/company/Admin.vue ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Admin_vue_vue_type_template_id_1b5d65d9__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Admin.vue?vue&type=template&id=1b5d65d9 */ "./resources/js/src/pages/company/Admin.vue?vue&type=template&id=1b5d65d9");
/* harmony import */ var _Admin_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Admin.vue?vue&type=script&lang=js */ "./resources/js/src/pages/company/Admin.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Admin_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Admin_vue_vue_type_template_id_1b5d65d9__WEBPACK_IMPORTED_MODULE_0__.render,
  _Admin_vue_vue_type_template_id_1b5d65d9__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/pages/company/Admin.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/src/pages/company/Admin.vue?vue&type=script&lang=js":
/*!**************************************************************************!*\
  !*** ./resources/js/src/pages/company/Admin.vue?vue&type=script&lang=js ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Admin.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/company/Admin.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/pages/company/Admin.vue?vue&type=template&id=1b5d65d9":
/*!********************************************************************************!*\
  !*** ./resources/js/src/pages/company/Admin.vue?vue&type=template&id=1b5d65d9 ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_template_id_1b5d65d9__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_template_id_1b5d65d9__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Admin_vue_vue_type_template_id_1b5d65d9__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Admin.vue?vue&type=template&id=1b5d65d9 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/company/Admin.vue?vue&type=template&id=1b5d65d9");


/***/ })

}]);