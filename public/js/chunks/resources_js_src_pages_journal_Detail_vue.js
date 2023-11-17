"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_src_pages_journal_Detail_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/journal/Detail.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/journal/Detail.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************************************/
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
      journal: {},
      rejectedNote: ""
    };
  },
  mounted: function mounted() {
    this.getData();
  },
  methods: {
    handleRejectShow: function handleRejectShow() {
      $("#rejectedModal").modal("show");
    },
    handleApproveReject: function handleApproveReject(type) {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var rejectedNoteLocal;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              rejectedNoteLocal = _this.rejectedNote;
              if (type == 'rejected') {
                $("#rejectedModal").modal("hide");
              }
              Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: "Are you sure?",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!"
              }).then( /*#__PURE__*/function () {
                var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(isConfirm) {
                  var respSave;
                  return _regeneratorRuntime().wrap(function _callee2$(_context2) {
                    while (1) switch (_context2.prev = _context2.next) {
                      case 0:
                        if (!isConfirm.isConfirmed) {
                          _context2.next = 14;
                          break;
                        }
                        _context2.prev = 1;
                        _this.$vs.loading();
                        _context2.next = 5;
                        return _this.$axios.post("api/journal/".concat(_this.$route.params.id, "/approval"), {
                          status: type,
                          note: rejectedNoteLocal
                        });
                      case 5:
                        respSave = _context2.sent;
                        _this.$vs.loading.close();
                        if (!respSave.status) {
                          Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                          });
                        } else {
                          $("#addCompany").modal("hide");
                          Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                          }).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
                            return _regeneratorRuntime().wrap(function _callee$(_context) {
                              while (1) switch (_context.prev = _context.next) {
                                case 0:
                                  _context.next = 2;
                                  return _this.getData();
                                case 2:
                                case "end":
                                  return _context.stop();
                              }
                            }, _callee);
                          })));
                        }
                        _context2.next = 14;
                        break;
                      case 10:
                        _context2.prev = 10;
                        _context2.t0 = _context2["catch"](1);
                        _this.$vs.loading.close();
                        Swal.fire({
                          position: 'top-end',
                          icon: 'error',
                          title: _context2.t0.message,
                          showConfirmButton: false,
                          timer: 1500
                        });
                      case 14:
                      case "end":
                        return _context2.stop();
                    }
                  }, _callee2, null, [[1, 10]]);
                }));
                return function (_x) {
                  return _ref.apply(this, arguments);
                };
              }());
            case 3:
            case "end":
              return _context3.stop();
          }
        }, _callee3);
      }))();
    },
    showDebitAndCredit: function showDebitAndCredit(journalItems, type) {
      var debitLocal = 0;
      var creditLocal = 0;
      if (type === 'debit') {
        journalItems.forEach(function (x) {
          debitLocal = debitLocal + parseFloat(x.debit);
        });
      }
      if (type === 'credit') {
        journalItems.forEach(function (x) {
          creditLocal = creditLocal + parseFloat(x.credit);
        });
      }
      return type === 'debit' ? debitLocal : creditLocal;
    },
    getData: function getData() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var respDe;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _context4.prev = 0;
              _this2.$vs.loading();
              _context4.next = 4;
              return _this2.$axios.get("api/journal/".concat(_this2.$route.params.id, "/detail"));
            case 4:
              respDe = _context4.sent;
              _this2.$vs.loading.close();
              if (respDe.status) {
                _context4.next = 9;
                break;
              }
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: respDe.message,
                showConfirmButton: false,
                timer: 1500
              });
              return _context4.abrupt("return");
            case 9:
              _this2.journal = respDe.data;
              _context4.next = 16;
              break;
            case 12:
              _context4.prev = 12;
              _context4.t0 = _context4["catch"](0);
              _this2.$vs.loading.close();
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: _context4.t0.message,
                showConfirmButton: false,
                timer: 1500
              });
            case 16:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[0, 12]]);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/journal/Detail.vue?vue&type=template&id=0400ae3d":
/*!******************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/journal/Detail.vue?vue&type=template&id=0400ae3d ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************/
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
  }, [_vm._v("Journal Detail")]), _vm._v(" "), _c("router-link", {
    staticClass: "btn btn-success float-right mt-3 mr-3",
    attrs: {
      to: "/app/journal"
    }
  }, [_c("i", {
    staticClass: "fa fa-arrow-left"
  }), _vm._v(" Back\n            ")])], 1), _vm._v(" "), _c("div", {
    staticClass: "card-body"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-6"
  }, [_c("table", {
    staticClass: "table table-striped"
  }, [_vm._m(0), _vm._v(" "), _c("tbody", [_c("tr", [_c("th", [_vm._v("Transaction UID")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.journal.transaction_uid))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Voucher NO")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.journal.voucher_no))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Title")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.journal.title))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Transaction Date")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.journal.transaction_date))])]), _vm._v(" "), _c("tr", [_c("th", [_vm._v("Status")]), _vm._v(" "), _c("td", {
    staticClass: "text-right"
  }, [_vm._v(_vm._s(_vm.journal.approved_at ? "Approved" : _vm.journal.rejected_at ? "Rejected" : "Requested"))])])])])])]), _vm._v(" "), _vm._m(1), _vm._v(" "), _c("div", {
    staticClass: "table-responsive"
  }, [_c("table", {
    staticClass: "table table-bordered",
    attrs: {
      id: "dataTable",
      width: "100%",
      cellspacing: "0"
    }
  }, [_vm._m(2), _vm._v(" "), _c("tbody", [_c("tr", {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.journal.journal_items.length == 0,
      expression: "journal.journal_items.length == 0"
    }]
  }, [_c("td", {
    staticClass: "text-center",
    attrs: {
      colspan: "6"
    }
  }, [_vm._v("\n                            Empty Items\n                        ")])]), _vm._v(" "), _vm._l(_vm.journal.journal_items, function (item, key) {
    return _c("tr", [_c("td", [_vm._v(_vm._s(item.account.account_number))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(item.account.account_name))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(item.cashflow_id ? item.cashflow.name : "-"))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(item.description))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm._f("formatPriceWithDecimal")(item.debit)))]), _vm._v(" "), _c("td", [_vm._v(_vm._s(_vm._f("formatPriceWithDecimal")(item.credit)))])]);
  }), _vm._v(" "), _c("tr", [_c("td", {
    attrs: {
      colspan: "4"
    }
  }), _vm._v(" "), _c("td", [_c("div", {
    staticClass: "d-flex flex-column"
  }, [_c("span", [_vm._v("Total Debit")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm._f("formatPriceWithDecimal")(_vm.showDebitAndCredit(_vm.journal.journal_items, "debit"))))])])]), _vm._v(" "), _c("td", [_c("div", {
    staticClass: "d-flex flex-column"
  }, [_c("span", [_vm._v("Total Credit")]), _vm._v(" "), _c("span", [_vm._v(_vm._s(_vm._f("formatPriceWithDecimal")(_vm.showDebitAndCredit(_vm.journal.journal_items, "credit"))))])])])]), _vm._v(" "), _vm.journal.approved_at === null && _vm.journal.rejected_at === null && _vm.$store.state.permissions.includes("company_set_admin") ? _c("tr", [_c("td", {
    staticClass: "text-right",
    attrs: {
      colspan: "6"
    }
  }, [_c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.handleApproveReject("approved");
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-check"
  }), _vm._v(" Approved\n                            ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-danger",
    attrs: {
      type: "button"
    },
    on: {
      click: function click($event) {
        return _vm.handleRejectShow();
      }
    }
  }, [_c("i", {
    staticClass: "fa fa-times"
  }), _vm._v(" Rejected\n                            ")])])]) : _vm._e()], 2)])])]), _vm._v(" "), _c("div", {
    staticClass: "modal fade",
    attrs: {
      id: "rejectedModal",
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
  }, [_vm._m(3), _vm._v(" "), _c("div", {
    staticClass: "modal-body"
  }, [_c("form", [_c("div", {
    staticClass: "form-group"
  }, [_vm._m(4), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.rejectedNote,
      expression: "rejectedNote"
    }],
    staticClass: "form-control",
    attrs: {
      type: "text"
    },
    domProps: {
      value: _vm.rejectedNote
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.rejectedNote = $event.target.value;
      }
    }
  })])])]), _vm._v(" "), _c("div", {
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
        return _vm.handleApproveReject("rejected");
      }
    }
  }, [_vm._v("Save changes")])])])])])])]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", {
    staticClass: "text-center",
    attrs: {
      colspan: "2"
    }
  }, [_vm._v("Details")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-lg-12"
  }, [_c("h3", {
    staticClass: "h3 text-gray-800 float-left"
  }, [_vm._v("Items")])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c("thead", [_c("tr", [_c("th", [_vm._v("Account Number")]), _vm._v(" "), _c("th", [_vm._v("Account")]), _vm._v(" "), _c("th", [_vm._v("Cashflow")]), _vm._v(" "), _c("th", [_vm._v("Description")]), _vm._v(" "), _c("th", [_vm._v("Debit (IDR)")]), _vm._v(" "), _c("th", [_vm._v("Credit (IDR)")])])]);
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
  }, [_vm._v("Reject Approval")]), _vm._v(" "), _c("button", {
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
  return _c("label", [_vm._v("Rejected Note"), _c("span", {
    staticStyle: {
      color: "red",
      "font-weight": "bold",
      "font-style": "italic"
    }
  }, [_vm._v("*) required")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/src/pages/journal/Detail.vue":
/*!***************************************************!*\
  !*** ./resources/js/src/pages/journal/Detail.vue ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Detail_vue_vue_type_template_id_0400ae3d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Detail.vue?vue&type=template&id=0400ae3d */ "./resources/js/src/pages/journal/Detail.vue?vue&type=template&id=0400ae3d");
/* harmony import */ var _Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Detail.vue?vue&type=script&lang=js */ "./resources/js/src/pages/journal/Detail.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Detail_vue_vue_type_template_id_0400ae3d__WEBPACK_IMPORTED_MODULE_0__.render,
  _Detail_vue_vue_type_template_id_0400ae3d__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/src/pages/journal/Detail.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/src/pages/journal/Detail.vue?vue&type=script&lang=js":
/*!***************************************************************************!*\
  !*** ./resources/js/src/pages/journal/Detail.vue?vue&type=script&lang=js ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Detail.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/journal/Detail.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/src/pages/journal/Detail.vue?vue&type=template&id=0400ae3d":
/*!*********************************************************************************!*\
  !*** ./resources/js/src/pages/journal/Detail.vue?vue&type=template&id=0400ae3d ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_0400ae3d__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_0400ae3d__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Detail_vue_vue_type_template_id_0400ae3d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Detail.vue?vue&type=template&id=0400ae3d */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/src/pages/journal/Detail.vue?vue&type=template&id=0400ae3d");


/***/ })

}]);