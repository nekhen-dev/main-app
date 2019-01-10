(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/minhas-ucs.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/minhas-ucs.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["inicializacao", "uc_add"],
  data: function data() {
    return {
      dados: {},
      uc_destaque: this.uc_add,
      filtro: {}
    };
  },
  mounted: function mounted() {
    this.dados = JSON.parse(this.inicializacao);
  },
  watch: {
    filtro: function filtro() {
      this.buscar();
    }
  },
  methods: {
    buscar: function buscar() {
      var _this = this;

      var url = '/plataforma/api/get_MinhasUcs/' + this.filtro.uf + '/' + this.arrayToString(this.filtro.municipios) + '/' + this.arrayToString(this.filtro.concessionarias) + '/' + 'novo';
      axios.get(url).then(function (response) {
        return _this.dados = response.data;
      });
    },
    arrayToString: function arrayToString(arr) {
      if (arr.length == 0) {
        return 'all';
      }

      var str = '';

      for (var i = 0; i < arr.length; i++) {
        str += arr[i].valor;

        if (i < arr.length - 1) {
          str += ',';
        }
      }

      return str;
    },
    testeDados: function testeDados() {
      if (this.dados != undefined) {
        return this.dados.ucs.length > 0;
      }

      return false;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/minhas-ucs.vue?vue&type=template&id=48ddd02a&":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/minhas-ucs.vue?vue&type=template&id=48ddd02a& ***!
  \*************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    !_vm.testeDados
      ? _c(
          "div",
          [
            _c("center", [
              _c("h4", [_vm._v("Isto aqui que está meio deserto")]),
              _vm._v(" "),
              _c("span", { staticClass: "lead" }, [
                _vm._v("Você ainda não tem unidades consumidoras cadastradas")
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "deserto" }),
              _vm._v(" "),
              _c("div", [
                _c(
                  "a",
                  {
                    staticClass: "btn btn-primary",
                    attrs: {
                      name: "add_uc",
                      id: "add_uc",
                      href: "/plataforma/consumidor/CadastrarUC",
                      role: "button"
                    }
                  },
                  [
                    _vm._v(
                      "\n                    Cadastre uma unidade consumidora\n                "
                    )
                  ]
                )
              ])
            ])
          ],
          1
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.testeDados
      ? _c(
          "div",
          [
            _c("h5", [_vm._v("Minhas unidades consumidoras")]),
            _vm._v(" "),
            _c("p", [
              _vm._v(
                "Clique nos cartões para exibir detalhes das unidades consumidoras"
              )
            ]),
            _vm._v(" "),
            _c(
              "div",
              [
                _c(
                  "a",
                  {
                    staticClass: "btn btn-primary btn-adicionar-top",
                    attrs: {
                      name: "",
                      id: "",
                      href: "/plataforma/consumidor/CadastrarUC",
                      role: "button"
                    }
                  },
                  [_vm._v("Adicionar")]
                ),
                _vm._v(" "),
                _c("br"),
                _c("br"),
                _vm._v(" "),
                _c("filtro-ucs", {
                  on: {
                    filtrar: function($event) {
                      _vm.filtro = $event
                    }
                  }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c("lista-ucs", {
              attrs: { lista: _vm.dados.ucs, uc_destaque: _vm.uc_destaque }
            })
          ],
          1
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return normalizeComponent; });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./resources/js/components/minhas-ucs.vue":
/*!************************************************!*\
  !*** ./resources/js/components/minhas-ucs.vue ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _minhas_ucs_vue_vue_type_template_id_48ddd02a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./minhas-ucs.vue?vue&type=template&id=48ddd02a& */ "./resources/js/components/minhas-ucs.vue?vue&type=template&id=48ddd02a&");
/* harmony import */ var _minhas_ucs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./minhas-ucs.vue?vue&type=script&lang=js& */ "./resources/js/components/minhas-ucs.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _minhas_ucs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _minhas_ucs_vue_vue_type_template_id_48ddd02a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _minhas_ucs_vue_vue_type_template_id_48ddd02a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/minhas-ucs.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/minhas-ucs.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/minhas-ucs.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_minhas_ucs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./minhas-ucs.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/minhas-ucs.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_minhas_ucs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/minhas-ucs.vue?vue&type=template&id=48ddd02a&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/minhas-ucs.vue?vue&type=template&id=48ddd02a& ***!
  \*******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_minhas_ucs_vue_vue_type_template_id_48ddd02a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./minhas-ucs.vue?vue&type=template&id=48ddd02a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/minhas-ucs.vue?vue&type=template&id=48ddd02a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_minhas_ucs_vue_vue_type_template_id_48ddd02a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_minhas_ucs_vue_vue_type_template_id_48ddd02a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);