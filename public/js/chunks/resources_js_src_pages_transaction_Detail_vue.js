"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_src_pages_transaction_Detail_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/transaction/Detail.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/transaction/Detail.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************************/
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
      transactionData: null,
      formData: {
        id: "",
        title: "",
        attachment: "",
        tax_type: "",
        ppn: {
          label: "",
          value: 0
        },
        pph: {
          label: "",
          value: 0
        },
        input_tax: 0,
        input: 0,
        note: '',
        ppn_value: 0,
        pph_value: 0,
        dpp_value: 0,
        total_value: 0
      },
      formDataCoa: {
        id: "",
        title: "",
        attachment: "",
        tax_type: "",
        ppn_type: "",
        pph_type: "",
        note: '',
        ppn_value: 0,
        pph_value: 0,
        dpp_value: 0,
        total_amount: 0,
        coa_items: []
      },
      ppns: [],
      pphs: [],
      coas: [],
      cashflows: [],
      formDataMethod: {
        method: "",
        transaction_date: ""
      }
    };
  },
  mounted: function mounted() {
    this.getData();
    this.getTax();
    this.getDataCoa();
  },
  methods: {
    handleShowMethod: function handleShowMethod() {
      $("#setMethodModal").modal("show");
    },
    handleForcedStatus: function handleForcedStatus() {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var respDe;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              _context.prev = 0;
              _this.$vs.loading();
              _context.next = 4;
              return _this.$axios.get("api/transaction/".concat(_this.$route.params.id, "/forced-status"));
            case 4:
              respDe = _context.sent;
              _this.$vs.loading.close();
              if (respDe.status) {
                _context.next = 10;
                break;
              }
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: respDe.message,
                showConfirmButton: false,
                timer: 1500
              });
              _context.next = 12;
              break;
            case 10:
              _context.next = 12;
              return _this.getData();
            case 12:
              _context.next = 18;
              break;
            case 14:
              _context.prev = 14;
              _context.t0 = _context["catch"](0);
              _this.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 18:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[0, 14]]);
      }))();
    },
    handleCheckSet: function handleCheckSet(transactionData, permission) {
      if (['rejected', 'requested'].includes(transactionData.current_status)) {
        return false;
      }
      if (this.$store.state.permissions.includes(permission)) {
        var approvalStatus = transactionData.transaction_approvals.find(function (x) {
          return x.title === (permission === 'transaction_edit_tax' ? 'Tax Admin' : 'Accounting Admin');
        });
        if (approvalStatus.approved_at || approvalStatus.rejected_at) {
          return false;
        }
        return true;
      }
      return false;
    },
    handleCheckApproval: function handleCheckApproval(transactionData, item) {
      console.log("oke");
      if (!this.$store.state.permissions.includes('transaction_approval')) {
        return false;
      }
      var type = "";
      if (item.title === 'Accounting Admin') {
        type = 'transaction_edit_coa';
      }
      if (item.title === 'Tax Admin') {
        type = 'transaction_edit_tax';
      }
      if (type !== '') {
        if (!this.$store.state.permissions.includes(type)) {
          return false;
        }
      }
      if (transactionData.current_status === 'published' && item.user.email === this.$store.state.email && !item.approved_at && !item.rejected_at) {
        return true;
      }
      return false;
    },
    handleAddCoaItem: function handleAddCoaItem() {
      var coaItems = this.formDataCoa.coa_items;
      coaItems.push({
        coa: '',
        debit: 0,
        credit: 0,
        cashflow: ""
      });
      this.formDataCoa.coa_items = coaItems;
    },
    handleDeleteCoaItem: function handleDeleteCoaItem(index) {
      var coaItems = this.formDataCoa.coa_items.filter(function (x, i) {
        return i !== index;
      });
      this.formDataCoa.coa_items = coaItems;
    },
    getDataCoa: function getDataCoa() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.prev = 0;
              _this2.$vs.loading();
              _context2.next = 4;
              return _this2.$axios.get("api/coa/by-company?is_active=1&transaction_id=".concat(_this2.$route.params.id));
            case 4:
              _this2.coas = _context2.sent;
              _context2.next = 7;
              return _this2.$axios.get('api/coa/cashflow');
            case 7:
              _this2.cashflows = _context2.sent;
              _this2.$vs.loading.close();
              _context2.next = 15;
              break;
            case 11:
              _context2.prev = 11;
              _context2.t0 = _context2["catch"](0);
              _this2.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context2.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 15:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[0, 11]]);
      }))();
    },
    handleSubmitEditMethod: function handleSubmitEditMethod() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var respDe;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _context4.prev = 0;
              _this3.$vs.loading();
              _context4.next = 4;
              return _this3.$axios.post("api/transaction/".concat(_this3.$route.params.id, "/set-method"), _this3.formDataMethod);
            case 4:
              respDe = _context4.sent;
              _this3.$vs.loading.close();
              if (!respDe.status) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                });
              } else {
                $("#setMethodModal").modal("hide");
                Swal.fire({
                  position: 'top',
                  icon: 'success',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
                  return _regeneratorRuntime().wrap(function _callee3$(_context3) {
                    while (1) switch (_context3.prev = _context3.next) {
                      case 0:
                        _context3.next = 2;
                        return _this3.getData();
                      case 2:
                      case "end":
                        return _context3.stop();
                    }
                  }, _callee3);
                })));
              }
              _context4.next = 13;
              break;
            case 9:
              _context4.prev = 9;
              _context4.t0 = _context4["catch"](0);
              _this3.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context4.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 13:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[0, 9]]);
      }))();
    },
    handleSubmitEditTax: function handleSubmitEditTax() {
      var _this4 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
        var paramSave, respDe;
        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
          while (1) switch (_context6.prev = _context6.next) {
            case 0:
              paramSave = {
                input_amount: _this4.formData.input_tax,
                pph_amount: _this4.formData.pph.value,
                pph_label: _this4.formData.pph.label + " " + parseFloat(_this4.formData.pph.value) + "%",
                ppn_amount: _this4.formData.ppn.value,
                ppn_label: _this4.formData.ppn.label + " " + parseFloat(_this4.formData.ppn.value) + "%",
                tax_amount: _this4.formData.input,
                tax_type: _this4.formData.tax_type
              };
              _context6.prev = 1;
              _this4.$vs.loading();
              _context6.next = 5;
              return _this4.$axios.post("api/transaction/".concat(_this4.$route.params.id, "/set-tax/").concat(_this4.formData.id), paramSave);
            case 5:
              respDe = _context6.sent;
              _this4.$vs.loading.close();
              if (!respDe.status) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                });
              } else {
                $("#setTaxModal").modal("hide");
                Swal.fire({
                  position: 'top',
                  icon: 'success',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5() {
                  return _regeneratorRuntime().wrap(function _callee5$(_context5) {
                    while (1) switch (_context5.prev = _context5.next) {
                      case 0:
                        _context5.next = 2;
                        return _this4.getData();
                      case 2:
                      case "end":
                        return _context5.stop();
                    }
                  }, _callee5);
                })));
              }
              _context6.next = 14;
              break;
            case 10:
              _context6.prev = 10;
              _context6.t0 = _context6["catch"](1);
              _this4.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context6.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 14:
            case "end":
              return _context6.stop();
          }
        }, _callee6, null, [[1, 10]]);
      }))();
    },
    handleSubmitEditCoa: function handleSubmitEditCoa() {
      var _this5 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee8() {
        var respDe;
        return _regeneratorRuntime().wrap(function _callee8$(_context8) {
          while (1) switch (_context8.prev = _context8.next) {
            case 0:
              _context8.prev = 0;
              _this5.$vs.loading();
              _context8.next = 4;
              return _this5.$axios.post("api/transaction/".concat(_this5.$route.params.id, "/set-coa/").concat(_this5.formDataCoa.id), _this5.formDataCoa.coa_items);
            case 4:
              respDe = _context8.sent;
              _this5.$vs.loading.close();
              if (!respDe.status) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                });
              } else {
                $("#setCoaModal").modal("hide");
                Swal.fire({
                  position: 'top',
                  icon: 'success',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee7() {
                  return _regeneratorRuntime().wrap(function _callee7$(_context7) {
                    while (1) switch (_context7.prev = _context7.next) {
                      case 0:
                        _context7.next = 2;
                        return _this5.getData();
                      case 2:
                      case "end":
                        return _context7.stop();
                    }
                  }, _callee7);
                })));
              }
              _context8.next = 13;
              break;
            case 9:
              _context8.prev = 9;
              _context8.t0 = _context8["catch"](0);
              _this5.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context8.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 13:
            case "end":
              return _context8.stop();
          }
        }, _callee8, null, [[0, 9]]);
      }))();
    },
    handleCalculate: function handleCalculate() {
      var dpp = 0;
      var ppn = 0;
      var pph = 0;
      var total = parseFloat(this.formData.input);
      if (this.formData.tax_type === 'ppn_gross') {
        var taxPercentage = parseFloat("1" + this.formData.ppn.value) - parseFloat(this.formData.pph.value);
        if (this.formData.ppn.value > 0 && this.formData.pph.value > 0) {
          dpp = 100 / taxPercentage * parseFloat(this.formData.input);
        } else {
          dpp = parseFloat(this.formData.input);
        }
        ppn = dpp * (this.formData.ppn.value / 100);
        pph = dpp * (this.formData.pph.value / 100);
        total = ppn + dpp - pph;
      } else if (this.formData.tax_type === 'ppn_reduce') {
        var _taxPercentage = parseFloat("1" + this.formData.ppn.value);
        if (this.formData.ppn.value > 0 && this.formData.pph.value > 0) {
          dpp = 100 / _taxPercentage * parseFloat(this.formData.input);
        } else {
          dpp = parseFloat(this.formData.input);
        }
        ppn = dpp * (this.formData.ppn.value / 100);
        pph = dpp * (this.formData.pph.value / 100);
        total = ppn + dpp - pph;
      } else if (this.formData.tax_type === 'exclude') {
        dpp = parseFloat(this.formData.input);
        ppn = dpp * (this.formData.ppn.value / 100);
        pph = dpp * (this.formData.pph.value / 100);
        if (parseFloat(this.formData.input_tax) < parseFloat(this.formData.input)) {
          total = ppn + dpp - pph + parseFloat(this.formData.input);
        } else {
          total = ppn + dpp - pph;
        }
      }
      this.formData.ppn_value = parseFloat(ppn).toFixed(0);
      this.formData.pph_value = parseFloat(pph).toFixed(0);
      this.formData.dpp_value = parseFloat(dpp).toFixed(0);
      this.formData.total_value = parseFloat(total).toFixed(0);
    },
    handleSetTax: function handleSetTax(item) {
      this.formData = {
        id: item.id,
        title: item.title,
        attachment: item.attachment,
        tax_type: "",
        ppn: {
          label: "",
          value: 0
        },
        pph: {
          label: "",
          value: 0
        },
        input_tax: item.input_amount,
        input: item.input_amount,
        note: item.note,
        ppn_value: 0,
        pph_value: 0,
        dpp_value: 0,
        total_value: 0
      };
      $("#setTaxModal").modal("show");
    },
    handleSetCoa: function handleSetCoa(item) {
      var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'edit';
      var coaItems = [{
        coa: '',
        debit: item.total_amount,
        credit: 0,
        cashflow: ""
      }, {
        coa: '',
        debit: 0,
        credit: item.total_amount,
        cashflow: ""
      }];
      if (item.transaction_item_coas.length > 0) {
        coaItems = [];
        item.transaction_item_coas.forEach(function (itemCoa, index) {
          coaItems.push({
            coa: parseInt(itemCoa.account_id),
            debit: itemCoa.debit,
            credit: itemCoa.credit,
            cashflow: itemCoa.cashflow_id ? parseInt(itemCoa.cashflow_id) : ""
          });
        });
      }
      this.formDataCoa = {
        id: item.id,
        title: item.title,
        attachment: item.attachment,
        tax_type: item.tax_type,
        ppn_type: item.ppn_label,
        pph_type: item.pph_label,
        total_amount: item.total_amount,
        note: item.note,
        ppn_value: item.ppn,
        pph_value: item.pph,
        dpp_value: item.dpp,
        coa_items: coaItems,
        type: type
      };
      $("#setCoaModal").modal("show");
    },
    handleApproval: function handleApproval(type, itemId) {
      var _this6 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee10() {
        var status, respDe;
        return _regeneratorRuntime().wrap(function _callee10$(_context10) {
          while (1) switch (_context10.prev = _context10.next) {
            case 0:
              _context10.prev = 0;
              _this6.$vs.loading();
              status = type === 1 ? 'approved' : 'rejected';
              _context10.next = 5;
              return _this6.$axios.get("api/transaction/".concat(_this6.$route.params.id, "/").concat(status, "/approval/").concat(itemId));
            case 5:
              respDe = _context10.sent;
              _this6.$vs.loading.close();
              if (!respDe.status) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                });
              } else {
                Swal.fire({
                  position: 'top',
                  icon: 'success',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee9() {
                  return _regeneratorRuntime().wrap(function _callee9$(_context9) {
                    while (1) switch (_context9.prev = _context9.next) {
                      case 0:
                        _context9.next = 2;
                        return _this6.getData();
                      case 2:
                      case "end":
                        return _context9.stop();
                    }
                  }, _callee9);
                })));
              }
              _context10.next = 14;
              break;
            case 10:
              _context10.prev = 10;
              _context10.t0 = _context10["catch"](0);
              _this6.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context10.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 14:
            case "end":
              return _context10.stop();
          }
        }, _callee10, null, [[0, 10]]);
      }))();
    },
    handlePublish: function handlePublish() {
      var _this7 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee11() {
        var respDe;
        return _regeneratorRuntime().wrap(function _callee11$(_context11) {
          while (1) switch (_context11.prev = _context11.next) {
            case 0:
              _context11.prev = 0;
              _this7.$vs.loading();
              _context11.next = 4;
              return _this7.$axios.get("api/transaction/".concat(_this7.$route.params.id, "/publish"));
            case 4:
              respDe = _context11.sent;
              _this7.$vs.loading.close();
              if (respDe.status) {
                _context11.next = 10;
                break;
              }
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: respDe.message,
                showConfirmButton: false,
                timer: 1500
              });
              _context11.next = 12;
              break;
            case 10:
              _context11.next = 12;
              return _this7.getData();
            case 12:
              _context11.next = 18;
              break;
            case 14:
              _context11.prev = 14;
              _context11.t0 = _context11["catch"](0);
              _this7.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context11.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 18:
            case "end":
              return _context11.stop();
          }
        }, _callee11, null, [[0, 14]]);
      }))();
    },
    getData: function getData() {
      var _this8 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee12() {
        var respDe;
        return _regeneratorRuntime().wrap(function _callee12$(_context12) {
          while (1) switch (_context12.prev = _context12.next) {
            case 0:
              _context12.prev = 0;
              _this8.$vs.loading();
              _context12.next = 4;
              return _this8.$axios.get("api/transaction/".concat(_this8.$route.params.id, "/detail"));
            case 4:
              respDe = _context12.sent;
              _this8.$vs.loading.close();
              if (!respDe.status) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: respDe.message,
                  showConfirmButton: false,
                  timer: 1500
                });
              } else {
                _this8.transactionData = respDe.data;
              }
              _context12.next = 13;
              break;
            case 9:
              _context12.prev = 9;
              _context12.t0 = _context12["catch"](0);
              _this8.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context12.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 13:
            case "end":
              return _context12.stop();
          }
        }, _callee12, null, [[0, 9]]);
      }))();
    },
    getTax: function getTax() {
      var _this9 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee13() {
        var respDe;
        return _regeneratorRuntime().wrap(function _callee13$(_context13) {
          while (1) switch (_context13.prev = _context13.next) {
            case 0:
              _context13.prev = 0;
              _this9.$vs.loading();
              _context13.next = 4;
              return _this9.$axios.get("api/tax");
            case 4:
              respDe = _context13.sent;
              _this9.$vs.loading.close();
              _this9.pphs = respDe.filter(function (x) {
                return x.type === 'pph';
              });
              _this9.ppns = respDe.filter(function (x) {
                return x.type === 'ppn';
              });
              _context13.next = 14;
              break;
            case 10:
              _context13.prev = 10;
              _context13.t0 = _context13["catch"](0);
              _this9.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context13.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 14:
            case "end":
              return _context13.stop();
          }
        }, _callee13, null, [[0, 10]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/transaction/Detail.vue?vue&type=template&id=27713e36":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/transaction/Detail.vue?vue&type=template&id=27713e36 ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _vm.transactionData !== null ? _c("div", {
    staticClass: "container-fluid"
  }, [_c("div", {
    staticClass: "card"
  }, [_c("div", {
    staticClass: "card-title"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-6"
  }, [_c("h1", {
    staticClass: "h3 mt-3 ml-3 text-primary"
  }, [_vm._v(_vm._s(_vm.transactionData.company.title))]), _vm._v(" "), _c("p", {
    staticClass: "ml-3"
  }, [_vm._v("Team/Project: " + _vm._s(_vm.transactionData.project.title))]), _vm._v(" "), _c("p", {
    staticClass: "ml-3 text-success"
  }, [_vm._v(_vm._s(_vm.transactionData.current_status.toUpperCase()))])]), _vm._v(" "), _c("div", {
    staticClass: "col-6 text-right"
  }, [_c("router-link", {
    staticClass: "btn btn-success mt-3 mr-3",
    attrs: {
      to: "/app/transaction"
    }
  }, [_c("i", {
    staticClass: "fa fa-arrow-left"
  }), _vm._v(" Back\n                    ")]), _vm._v(" "), _vm.transactionData.current_status === "requested" ? _c("button", {
    staticClass: "btn btn-primary mt-3 mr-3",
    on: {
      click: function click($event) {
        return _vm.handlePublish();
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-check"
  }), _vm._v(" Publish\n                    ")]) : _vm._e(), _vm._v(" "), _c("p", {
    staticClass: "mr-3 mt-2"
  }, [_vm._v("Transaction #" + _vm._s(_vm.transactionData.transaction_number))])], 1)])]), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-md-6 col-xl-8"
  }, [_c("table", {
    staticClass: "table table-striped"
  }, [_c("tbody", [_c("tr", [_c("th", [_vm._v("Created By")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.transactionData.user_created_by.name))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Created At")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm._f("formatDate")(_vm.transactionData.created_at)))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Transaction Date")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.transactionData.transaction_date ? _vm.transactionData.transaction_date | _vm.formatDate : "-"))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Title")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.transactionData.title))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Bank")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.transactionData.bank))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Account Holder")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.transactionData.account_holder))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Account Name")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.transactionData.account_number))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("PPn")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.transactionData.ppn)))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("PPh")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.transactionData.pph)))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("DPP")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.transactionData.dpp)))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("TOTAL")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.transactionData.total_amount)))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Transaction Method")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v("\n                                " + _vm._s(_vm.transactionData.method) + " - " + _vm._s(_vm.transactionData.transaction_date)), _vm._v(" "), _vm.$store.state.permissions.includes("transaction_cancel_approval") ? _c("button", {
    staticClass: "btn-success",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.handleShowMethod();
      }
    }
  }, [_c("i", {
    staticClass: "fas fa-pen-alt"
  })]) : _vm._e()])])])])]), _vm._v(" "), _c("div", {
    staticClass: "col-md-6 col-xl-4"
  }, [_c("table", {
    staticClass: "table table-striped"
  }, [_c("tbody", _vm._l(_vm.transactionData.transaction_statuses, function (tSt, tI) {
    return _c("tr", {
      key: tI
    }, [_c("th", [_vm._v(_vm._s(tSt.title))]), _vm._v(" "), _c("td", {
      staticClass: "text-right"
    }, [_vm._v(_vm._s(_vm._f("formatDate")(tSt.created_at)))])]);
  }), 0)]), _vm._v(" "), _vm.transactionData.transaction_flip ? _c("table", {
    staticClass: "table table-striped mt-5"
  }, [_c("tbody", [_c("tr", [_c("th", [_vm._v("Status")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.transactionData.transaction_flip.status))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Fee")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm._f("formatPriceWithDecimal")(_vm.transactionData.transaction_flip.fee)))])]), _vm._v(" "), _vm.transactionData.transaction_flip.receipt_file ? _c("tr", [_c("th", [_vm._v("Receipt")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_c("a", {
    attrs: {
      href: _vm.transactionData.transaction_flip.receipt_file
    }
  }, [_c("i", {
    staticClass: "fas fa-link"
  })])])]) : _vm._e()])]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "table-responsive"
  }, [_c("table", {
    staticClass: "table table-bordered",
    attrs: {
      id: "dataTable",
      width: "100%",
      cellspacing: "0"
    }
  }, [_vm._m(0), _vm._v(" "), _c("tbody", [_c("tr", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.transactionData.transaction_items.length == 0,
      expression: "transactionData.transaction_items.length == 0"
    }]
  }, [_c("td", {
    staticClass: "text-center",
    attrs: {
      colspan: "6"
    }
  }, [_vm._v("\n                            Items\n                        ")])]), _vm._v(" "), _vm._l(_vm.transactionData.transaction_items, function (item, key) {
    return _c("tr", [_c("td", [_c("strong", [_vm._v(_vm._s(key + 1))])]), _vm._v(" "), _c("td", [_vm._v(_vm._s(item.title))]), _vm._v(" "), _c("td", [_c("a", {
      attrs: {
        href: item.attachment,
        target: "_blank"
      }
    }, [_c("i", {
      staticClass: "fas fa-link"
    })])]), _vm._v(" "), _c("td", [_vm._v("Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(item.input_amount)))]), _vm._v(" "), _c("td", [_vm._v("Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(item.total_amount)))]), _vm._v(" "), _c("td", [_c("button", {
      staticClass: "btn btn-info",
      attrs: {
        disabled: !_vm.handleCheckSet(_vm.transactionData, "transaction_edit_tax"),
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.handleSetTax(item);
        }
      }
    }, [_vm._v("\n                                Set Tax\n                            ")]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-primary",
      attrs: {
        disabled: !_vm.handleCheckSet(_vm.transactionData, "transaction_edit_coa"),
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.handleSetCoa(item);
        }
      }
    }, [_vm._v("\n                                Set Coa\n                            ")]), _vm._v(" "), _c("button", {
      staticClass: "btn btn-success",
      attrs: {
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.handleSetCoa(item, "view");
        }
      }
    }, [_vm._v("\n                                Detail\n                            ")])])]);
  })], 2)])]), _vm._v(" "), _vm.transactionData.current_status !== "requested" ? _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-12"
  }, [_c("table", {
    staticClass: "table table-striped"
  }, [_c("tbody", [_vm._l(_vm.transactionData.transaction_approvals, function (item, index) {
    return _c("tr", {
      key: index
    }, [_c("th", [_c("div", {
      staticClass: "d-flex"
    }, [_c("span", {
      staticClass: "avatar align-content-center"
    }, [_vm._v(_vm._s(_vm._f("getShortName")(item.user.name)))]), _vm._v(" "), _c("div", {
      staticClass: "ml-2"
    }, [_c("label", [_vm._v(_vm._s(item.user.name))]), _vm._v(" "), _c("br"), _vm._v(" "), _c("label", [_vm._v(_vm._s(item.title))])])])]), _vm._v(" "), _c("td", {
      staticClass: "text-right"
    }, [_vm.transactionData.current_status === "rejected" ? _c("label", [_vm._v("Transaction Rejected")]) : _c("label", [_vm.handleCheckApproval(_vm.transactionData, item) ? _c("button", {
      staticClass: "btn btn-primary mt-3 mr-3",
      on: {
        click: function click($event) {
          return _vm.handleApproval(1, item.id);
        }
      }
    }, [_c("i", {
      staticClass: "fa fa-check"
    }), _vm._v(" Approve\n                                    ")]) : _vm._e(), _vm._v(" "), _vm.handleCheckApproval(_vm.transactionData, item, "transaction_edit_tax") ? _c("button", {
      staticClass: "btn btn-danger mt-3 mr-3",
      on: {
        click: function click($event) {
          return _vm.handleApproval(0, item.id);
        }
      }
    }, [_c("i", {
      staticClass: "fa fa-times"
    }), _vm._v(" Reject\n                                    ")]) : _vm._e(), _vm._v("\n                                    " + _vm._s(item.approved_at ? "Approved at " + item.approved_at : item.rejected_at ? "Transaction rejected" : _vm.transactionData.current_status === "published" && item.user.email === _vm.$store.state.email ? "" : "Waiting Action") + "\n                                ")])])]);
  }), _vm._v(" "), _vm.$store.state.permissions.includes("transaction_cancel_approval") && _vm.transactionData === "published" ? _c("tr", [_c("td", {
    staticClass: "text-right align-content-center",
    attrs: {
      colspan: "2"
    },
    on: {
      click: function click($event) {
        return _vm.handleForcedStatus();
      }
    }
  }, [_c("button", {
    staticClass: "btn btn-info mt-3 mr-3"
  }, [_vm._v("\n                                    Forced Status\n                                ")])])]) : _vm._e()], 2)])])]) : _vm._e(), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "setMethodModal",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "exampleModalLabel"
    }
  }, [_c("div", {
    staticClass: "modal-dialog",
    attrs: {
      role: "document"
    }
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_vm._m(1), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("form", [_c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(2), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.formDataMethod.method,
      expression: "formDataMethod.method"
    }],
    staticClass: "form-control",
    on: {
      change: function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.formDataMethod, "method", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c("option", {
    attrs: {
      value: "",
      selected: ""
    }
  }, [_vm._v("--Select Method--")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "flip"
    }
  }, [_vm._v("Flip")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "manual"
    }
  }, [_vm._v("Manual")])])])]), _vm._v(" "), _vm.formDataMethod.method === "manual" ? _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(3), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.formDataMethod.transaction_date,
      expression: "formDataMethod.transaction_date"
    }],
    staticClass: "form-control",
    attrs: {
      type: "date"
    },
    domProps: {
      value: _vm.formDataMethod.transaction_date
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.formDataMethod, "transaction_date", $event.target.value);
      }
    }
  })])]) : _vm._e()])]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer flex justify-content-between"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      type: "button",
      "data-dismiss": "modal"
    }
  }, [_vm._v("Close")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.handleSubmitEditMethod();
      }
    }
  }, [_vm._v("Save changes")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "setTaxModal",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "exampleModalLabel"
    }
  }, [_c("div", {
    staticClass: "modal-dialog modal-xl",
    attrs: {
      role: "document"
    }
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_vm._m(4), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("form", [_c("div", {
    staticClass: "row"
  }, [_vm._m(5), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("label", [_vm._v(_vm._s(_vm.formData.title))])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(6), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.formData.tax_type,
      expression: "formData.tax_type"
    }],
    staticClass: "form-control",
    on: {
      change: [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.formData, "tax_type", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.handleCalculate]
    }
  }, [_c("option", {
    attrs: {
      value: "",
      selected: ""
    }
  }, [_vm._v("--Select Tax Type--")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "ppn_gross"
    }
  }, [_vm._v("Include PPN gross up pph")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "ppn_reduce"
    }
  }, [_vm._v("Include PPN reduce pph")]), _vm._v(" "), _c("option", {
    attrs: {
      value: "exclude"
    }
  }, [_vm._v("Exclude")])])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(7), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.formData.ppn,
      expression: "formData.ppn"
    }],
    staticClass: "form-control",
    on: {
      change: [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.formData, "ppn", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.handleCalculate]
    }
  }, [_c("option", {
    attrs: {
      value: "",
      selected: ""
    }
  }, [_vm._v("--No PPN--")]), _vm._v(" "), _vm._l(_vm.ppns, function (ppn, index) {
    return _c("option", {
      key: index,
      domProps: {
        value: {
          label: ppn.title,
          value: ppn.amount
        }
      }
    }, [_vm._v(_vm._s(ppn.title) + " - " + _vm._s(ppn.amount) + "%")]);
  })], 2)])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(8), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("select", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.formData.pph,
      expression: "formData.pph"
    }],
    staticClass: "form-control",
    on: {
      change: [function ($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.formData, "pph", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }, _vm.handleCalculate]
    }
  }, [_c("option", {
    attrs: {
      value: "",
      selected: ""
    }
  }, [_vm._v("--No PPH--")]), _vm._v(" "), _vm._l(_vm.pphs, function (pph, index) {
    return _c("option", {
      key: index,
      domProps: {
        value: {
          label: pph.title,
          value: pph.amount
        }
      }
    }, [_vm._v(_vm._s(pph.title) + " - " + _vm._s(pph.amount) + "%")]);
  })], 2)])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(9), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-6"
  }, [_vm._v("\n                                                Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.formData.input_tax)) + "\n                                            ")]), _vm._v(" "), _c("div", {
    staticClass: "col-6"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.formData.input,
      expression: "formData.input"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text"
    },
    domProps: {
      value: _vm.formData.input
    },
    on: {
      keyup: _vm.handleCalculate,
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.formData, "input", $event.target.value);
      }
    }
  })])])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(10), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("a", {
    attrs: {
      href: _vm.formData.attachment,
      target: "_blank"
    }
  }, [_c("i", {
    staticClass: "fas fa-link"
  })])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(11), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        " + _vm._s(_vm.formData.note) + "\n                                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(12), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        " + _vm._s(_vm.formData.ppn_value) + "\n                                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(13), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        " + _vm._s(_vm.formData.pph_value) + "\n                                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(14), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        " + _vm._s(_vm.formData.dpp_value) + "\n                                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(15), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        " + _vm._s(_vm.formData.total_value) + "\n                                    ")])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer flex justify-content-between"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      type: "button",
      "data-dismiss": "modal"
    }
  }, [_vm._v("Close")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.handleSubmitEditTax();
      }
    }
  }, [_vm._v("Save changes")])])])])]), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "setCoaModal",
      tabindex: "-1",
      role: "dialog",
      "aria-labelledby": "exampleModalLabel"
    }
  }, [_c("div", {
    staticClass: "modal-dialog modal-xl",
    attrs: {
      role: "document"
    }
  }, [_c("div", {
    staticClass: "modal-content"
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title",
    attrs: {
      id: "exampleModalLabel"
    }
  }, [_vm._v(" " + _vm._s(_vm.formDataCoa.type === "edit" ? "Edit" : "View") + " Item")]), _vm._v(" "), _vm._m(16)]), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("form", [_c("div", {
    staticClass: "row"
  }, [_vm._m(17), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("label", [_vm._v(_vm._s(_vm.formDataCoa.title))])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(18), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("label", [_vm._v(_vm._s(_vm.formDataCoa.tax_type))])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(19), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("label", [_vm._v(_vm._s(_vm.formDataCoa.ppn_type))])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(20), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("label", [_vm._v(_vm._s(_vm.formDataCoa.pph_type))])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(21), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("label", [_vm._v("Rp.  " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.formDataCoa.input_amount)))])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(22), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_c("a", {
    attrs: {
      href: _vm.formDataCoa.attachment,
      target: "_blank"
    }
  }, [_c("i", {
    staticClass: "fas fa-link"
  })])])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(23), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        " + _vm._s(_vm.formDataCoa.note) + "\n                                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(24), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.formDataCoa.ppn_value)) + "\n                                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(25), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.formDataCoa.pph_value)) + "\n                                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(26), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.formDataCoa.dpp_value)) + "\n                                    ")])]), _vm._v(" "), _c("div", {
    staticClass: "row mt-3"
  }, [_vm._m(27), _vm._v(" "), _c("div", {
    staticClass: "col-8"
  }, [_vm._v("\n                                        Rp. " + _vm._s(_vm._f("formatPriceWithDecimal")(_vm.formDataCoa.total_amount)) + "\n                                    ")])]), _vm._v(" "), _c("hr"), _vm._v(" "), _vm._m(28), _vm._v(" "), _c("hr"), _vm._v(" "), _vm._l(_vm.formDataCoa.coa_items, function (coaItem, index) {
    return _c("div", {
      key: index,
      staticClass: "row mt-3"
    }, [_c("div", {
      staticClass: "col-3"
    }, [_c("label", {
      attrs: {
        "for": ""
      }
    }, [_vm._v("Account")]), _vm._v(" "), _c("select", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.formDataCoa.coa_items[index].coa,
        expression: "formDataCoa.coa_items[index].coa"
      }],
      staticClass: "form-control",
      attrs: {
        disabled: _vm.formDataCoa.type !== "edit"
      },
      on: {
        change: function change($event) {
          var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
            return o.selected;
          }).map(function (o) {
            var val = "_value" in o ? o._value : o.value;
            return val;
          });
          _vm.$set(_vm.formDataCoa.coa_items[index], "coa", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
        }
      }
    }, [_c("option", {
      attrs: {
        value: ""
      }
    }, [_vm._v("--Select Coa--")]), _vm._v(" "), _vm._l(_vm.coas, function (coa, index) {
      return _c("option", {
        key: index,
        domProps: {
          value: coa.id
        }
      }, [_vm._v(_vm._s(coa.account_code))]);
    })], 2)]), _vm._v(" "), _c("div", {
      staticClass: "col-2"
    }, [_c("label", {
      attrs: {
        "for": ""
      }
    }, [_vm._v("Debit")]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.formDataCoa.coa_items[index].debit,
        expression: "formDataCoa.coa_items[index].debit"
      }],
      staticClass: "form-control",
      attrs: {
        disabled: _vm.formDataCoa.type !== "edit",
        type: "number"
      },
      domProps: {
        value: _vm.formDataCoa.coa_items[index].debit
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(_vm.formDataCoa.coa_items[index], "debit", $event.target.value);
        }
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "col-2"
    }, [_c("label", {
      attrs: {
        "for": ""
      }
    }, [_vm._v("Credit")]), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.formDataCoa.coa_items[index].credit,
        expression: "formDataCoa.coa_items[index].credit"
      }],
      staticClass: "form-control",
      attrs: {
        disabled: _vm.formDataCoa.type !== "edit",
        type: "number"
      },
      domProps: {
        value: _vm.formDataCoa.coa_items[index].credit
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;
          _vm.$set(_vm.formDataCoa.coa_items[index], "credit", $event.target.value);
        }
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "col-4"
    }, [_c("label", {
      attrs: {
        "for": ""
      }
    }, [_vm._v("Cashflow")]), _vm._v(" "), _c("select", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: _vm.formDataCoa.coa_items[index].cashflow,
        expression: "formDataCoa.coa_items[index].cashflow"
      }],
      staticClass: "form-control",
      attrs: {
        disabled: _vm.formDataCoa.type !== "edit"
      },
      on: {
        change: function change($event) {
          var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
            return o.selected;
          }).map(function (o) {
            var val = "_value" in o ? o._value : o.value;
            return val;
          });
          _vm.$set(_vm.formDataCoa.coa_items[index], "cashflow", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
        }
      }
    }, [_c("option", {
      attrs: {
        value: ""
      }
    }, [_vm._v("--Select Cashflow--")]), _vm._v(" "), _vm._l(_vm.cashflows, function (cashflow, index) {
      return _c("option", {
        key: index,
        domProps: {
          value: cashflow.id
        }
      }, [_vm._v(_vm._s(cashflow.name))]);
    })], 2)]), _vm._v(" "), _vm.formDataCoa.type === "edit" ? _c("div", {
      staticClass: "col-1 align-content-center"
    }, [_c("button", {
      staticClass: "btn btn-danger",
      attrs: {
        type: "button"
      },
      on: {
        click: function click($event) {
          return _vm.handleDeleteCoaItem(index);
        }
      }
    }, [_c("i", {
      staticClass: "fas fa-trash"
    })])]) : _vm._e()]);
  }), _vm._v(" "), _vm.formDataCoa.type === "edit" ? _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.handleAddCoaItem();
      }
    }
  }, [_vm._v("Add Item")]) : _vm._e()], 2)]), _vm._v(" "), _c("div", {
    staticClass: "modal-footer flex justify-content-between"
  }, [_c("button", {
    staticClass: "btn btn-secondary",
    attrs: {
      type: "button",
      "data-dismiss": "modal"
    }
  }, [_vm._v("Close")]), _vm._v(" "), _vm.formDataCoa.type === "edit" ? _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.handleSubmitEditCoa();
      }
    }
  }, [_vm._v("Save changes")]) : _vm._e()])])])])])])]) : _vm._e();
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("No")]), _vm._v(" "), _c("th", [_vm._v("Title")]), _vm._v(" "), _c("th", [_vm._v("Attachment")]), _vm._v(" "), _c("th", [_vm._v("Input Total")]), _vm._v(" "), _c("th", [_vm._v("Total")]), _vm._v(" "), _c("th", [_vm._v("#")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title",
    attrs: {
      id: "exampleModalLabel"
    }
  }, [_vm._v("Change Transaction Method")]), _vm._v(" "), _c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Transaction Method"), _c("span", {
    staticStyle: {
      color: "red",
      "font-weight": "bold",
      "font-style": "italic"
    }
  }, [_vm._v("*) required")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Transaction Date"), _c("span", {
    staticStyle: {
      color: "red",
      "font-weight": "bold",
      "font-style": "italic"
    }
  }, [_vm._v("*) required")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title",
    attrs: {
      id: "exampleModalLabel"
    }
  }, [_vm._v("Edit Item")]), _vm._v(" "), _c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Title")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Tax Type"), _c("span", {
    staticStyle: {
      color: "red",
      "font-weight": "bold",
      "font-style": "italic"
    }
  }, [_vm._v("*) required")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("PPN Type"), _c("span", {
    staticStyle: {
      color: "red",
      "font-weight": "bold",
      "font-style": "italic"
    }
  }, [_vm._v("*) required")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("PPH Type"), _c("span", {
    staticStyle: {
      color: "red",
      "font-weight": "bold",
      "font-style": "italic"
    }
  }, [_vm._v("*) required")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Input Amount"), _c("span", {
    staticStyle: {
      color: "red",
      "font-weight": "bold",
      "font-style": "italic"
    }
  }, [_vm._v("*) required")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Attachment")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Note")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("PPN")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("PPH")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("DPP")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("TOTAL")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Title")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Tax Type")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("PPN Type")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("PPH Type")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Input Amount")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Attachment")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("Note")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("PPN")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("PPH")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("DPP")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "col-4"
  }, [_c("label", [_vm._v("TOTAL")])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-12 text-center"
  }, [_vm._v("\n                                        Journal Entries\n                                    ")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/src/pages/transaction/Detail.vue":
/*!*******************************************************!*\
  !*** ./resources/js/src/pages/transaction/Detail.vue ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Detail_vue_vue_type_template_id_27713e36__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Detail.vue?vue&type=template&id=27713e36 */ "./resources/js/src/pages/transaction/Detail.vue?vue&type=template&id=27713e36");
/* harmony import */ var _Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Detail.vue?vue&type=script&lang=js */ "./resources/js/src/pages/transaction/Detail.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Detail_vue_vue_type_template_id_27713e36__WEBPACK_IMPORTED_MODULE_0__.render,
  _Detail_vue_vue_type_template_id_27713e36__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/pages/transaction/Detail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/src/pages/transaction/Detail.vue?vue&type=script&lang=js":
/*!*******************************************************************************!*\
  !*** ./resources/js/src/pages/transaction/Detail.vue?vue&type=script&lang=js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Detail.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/transaction/Detail.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/pages/transaction/Detail.vue?vue&type=template&id=27713e36":
/*!*************************************************************************************!*\
  !*** ./resources/js/src/pages/transaction/Detail.vue?vue&type=template&id=27713e36 ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_27713e36__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_27713e36__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_27713e36__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Detail.vue?vue&type=template&id=27713e36 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/transaction/Detail.vue?vue&type=template&id=27713e36");


/***/ })

}]);