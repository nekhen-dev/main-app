(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[4],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/lista-ucs.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/lista-ucs.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
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
//
//
//
//
//
//
$(function () {
  $('[data-toggle="popover"]').popover();
});
/* harmony default export */ __webpack_exports__["default"] = ({
  props: ["lista", "uc_destaque"],
  data: function data() {
    return {
      ucs: this.lista,
      destaque: this.uc_destaque
    };
  },
  watch: {
    lista: function lista() {
      this.ucs = this.lista;
    }
  },
  filters: {
    setHrefCollapse: function setHrefCollapse(id) {
      return "#collapse-" + id;
    },
    setIdCollapse: function setIdCollapse(id) {
      return "collapse-" + id;
    },
    setId: function setId(id) {
      return "uc-" + id;
    },
    setData: function setData(data) {
      var d = data.split(" ")[0];
      d = d.split("-");
      return d[2] + "/" + d[1] + "/" + d[0];
    },
    enderecoCompleto: function enderecoCompleto(l) {
      var comp_endereco = "";

      if (l.comp_endereco !== undefined) {
        comp_endereco = ", " + l.comp_endereco;
      }

      return l.endereco + ', ' + l.num_endereco + comp_endereco + ', ' + l.uf + ', ' + l.cep;
    }
  },
  methods: {
    ifDestaque: function ifDestaque(id) {
      return id == this.destaque ? true : false;
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--5-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--5-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.uc-loop{\n    font-size:0.9em;\n    display:inline-block;\n}\n.uc-item{\n    cursor:pointer;\n    margin:10px 5px;\n    padding:20px;\n    border: 1px solid lightgrey;\n    box-shadow: 0 3px 10px lightgrey;\n    border-radius:5px;\n    min-width:400px;\n}\n@media screen and (max-width: 500px) {\n.uc-loop{\n        width:100%;\n}\n.uc-item{\n        min-width:auto;\n}\n}\n.uc-adicionada{\n    border-color:green;\n    border-width: 5px;\n}\n.uc-item:hover{\n    box-shadow: 0 5px 10px lightgrey;\n}\n.uc-card{\n    font-weight:bold;\n}\n.uc-icon{\n    background: url(\"/img/unidade_consumidora.png\") left no-repeat;\n}\n.uc-criado_em{\n    color:rgb(175, 175, 175);\n    font-size:0.8em;\n    font-weight:normal;\n}\n.uc-concessionaria{\n    background: url(\"/img/distribuição.png\") left no-repeat;\n}\n.uc-card-titulo{\n    background-size: 20px;\n    padding: 5px 0;\n    padding-left: 40px;\n}\n.uc-detalhe-container{\n    border-top:1px solid lightgrey;\n    margin:10px 0;\n}\n.lista-configuracao{\n    margin: 0;\n    margin-left:10px;\n    padding: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--5-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--5-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--5-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--5-2!../../../node_modules/vue-loader/lib??vue-loader-options!./lista-ucs.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/lista-ucs.vue?vue&type=template&id=b32a11c0&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/lista-ucs.vue?vue&type=template&id=b32a11c0& ***!
  \************************************************************************************************************************************************************************************************************/
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
    _vm.ucs.length > 0
      ? _c(
          "div",
          _vm._l(_vm.ucs, function(uc) {
            return _c(
              "div",
              { key: uc.hash, staticClass: "uc-loop align-top" },
              [
                _c(
                  "div",
                  {
                    staticClass: "uc-item",
                    class: [_vm.ifDestaque(uc.hash) ? "uc-adicionada" : ""],
                    staticStyle: { cursor: "pointer" },
                    attrs: { id: _vm._f("setId")(uc.hash) }
                  },
                  [
                    _c(
                      "div",
                      {
                        staticStyle: { "text-align": "left" },
                        attrs: {
                          "data-toggle": "collapse",
                          href: _vm._f("setHrefCollapse")(uc.hash)
                        }
                      },
                      [
                        _vm.ifDestaque(uc.hash)
                          ? _c("div", [
                              _c(
                                "span",
                                {
                                  staticStyle: {
                                    color: "green",
                                    "font-weight": "bold"
                                  }
                                },
                                [_vm._v("Unidade consumidora adicionada!")]
                              ),
                              _vm._v(" "),
                              _c("br")
                            ])
                          : _vm._e(),
                        _vm._v(" "),
                        _c("div", { staticClass: "uc-card" }, [
                          _c("div", { staticClass: "uc-icon uc-card-titulo" }, [
                            _vm._v(
                              "\n                            " +
                                _vm._s(uc.localizacao.municipio) +
                                ", " +
                                _vm._s(uc.localizacao.uf) +
                                " | " +
                                _vm._s(uc.consumo.total) +
                                " kWh\n                        "
                            )
                          ]),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "uc-concessionaria uc-card-titulo" },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(uc.configuracao.concessionaria) +
                                  "\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c("div", { staticClass: "uc-criado_em" }, [
                            _vm._v(
                              "\n                            Adicionado em: " +
                                _vm._s(_vm._f("setData")(uc.criado_em)) +
                                "\n                        "
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass: "collapse uc-detalhe-container",
                            attrs: { id: _vm._f("setIdCollapse")(uc.hash) }
                          },
                          [
                            _c("div", { staticStyle: { margin: "5px 0" } }, [
                              _c("h5", [_vm._v("Detalhes")]),
                              _vm._v(" "),
                              _c("strong", [_vm._v("Endereço")]),
                              _vm._v(" "),
                              _c("div", [
                                _vm._v(
                                  _vm._s(
                                    _vm._f("enderecoCompleto")(uc.localizacao)
                                  )
                                )
                              ])
                            ]),
                            _vm._v(" "),
                            _c("div", { staticStyle: { margin: "5px 0" } }, [
                              _c("strong", [_vm._v("Configuração")]),
                              _vm._v(" "),
                              _c("div", { staticClass: "container" }, [
                                _c(
                                  "ul",
                                  { staticClass: "lista-configuracao" },
                                  [
                                    _c("li", [
                                      _vm._v(
                                        "Concessionária: " +
                                          _vm._s(uc.configuracao.concessionaria)
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("li", [
                                      _vm._v(
                                        "Perfil: " +
                                          _vm._s(
                                            uc.configuracao.tipo_estabelecimento
                                          )
                                      )
                                    ]),
                                    _vm._v(" "),
                                    _c("li", [
                                      _vm._v(
                                        "Grupo: " +
                                          _vm._s(uc.configuracao.grupo)
                                      )
                                    ]),
                                    _vm._v(" "),
                                    uc.configuracao.classe
                                      ? _c("li", [
                                          _vm._v(
                                            "Classe: " +
                                              _vm._s(uc.configuracao.classe)
                                          )
                                        ])
                                      : _vm._e(),
                                    _vm._v(" "),
                                    _c("li", [
                                      _vm._v(
                                        "Modalidade: " +
                                          _vm._s(uc.configuracao.modalidade)
                                      )
                                    ])
                                  ]
                                )
                              ])
                            ]),
                            _vm._v(" "),
                            _c("div", { staticStyle: { margin: "5px 0" } }, [
                              _vm._m(0, true),
                              _vm._v(" "),
                              _c(
                                "div",
                                [
                                  _c("chart-consumo-uc", {
                                    attrs: { item: uc }
                                  })
                                ],
                                1
                              )
                            ])
                          ]
                        )
                      ]
                    )
                  ]
                )
              ]
            )
          }),
          0
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.ucs.length == 0
      ? _c("div", [
          _vm._v(
            "\n        Não foi possível encontrar unidades consumidoras este filtro.\n    "
          )
        ])
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticStyle: { "margin-bottom": "10px" } }, [
      _c("strong", [_vm._v("Consumo")])
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/lista-ucs.vue":
/*!***********************************************!*\
  !*** ./resources/js/components/lista-ucs.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _lista_ucs_vue_vue_type_template_id_b32a11c0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./lista-ucs.vue?vue&type=template&id=b32a11c0& */ "./resources/js/components/lista-ucs.vue?vue&type=template&id=b32a11c0&");
/* harmony import */ var _lista_ucs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./lista-ucs.vue?vue&type=script&lang=js& */ "./resources/js/components/lista-ucs.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _lista_ucs_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./lista-ucs.vue?vue&type=style&index=0&lang=css& */ "./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _lista_ucs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _lista_ucs_vue_vue_type_template_id_b32a11c0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _lista_ucs_vue_vue_type_template_id_b32a11c0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/lista-ucs.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/lista-ucs.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/components/lista-ucs.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./lista-ucs.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/lista-ucs.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************************!*\
  !*** ./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--5-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--5-2!../../../node_modules/vue-loader/lib??vue-loader-options!./lista-ucs.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/lista-ucs.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_5_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_5_2_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/lista-ucs.vue?vue&type=template&id=b32a11c0&":
/*!******************************************************************************!*\
  !*** ./resources/js/components/lista-ucs.vue?vue&type=template&id=b32a11c0& ***!
  \******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_template_id_b32a11c0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./lista-ucs.vue?vue&type=template&id=b32a11c0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/lista-ucs.vue?vue&type=template&id=b32a11c0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_template_id_b32a11c0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_lista_ucs_vue_vue_type_template_id_b32a11c0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);