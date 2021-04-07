@extends('acc::layouts.app')


@section('content')

    <div class="card card-default">
        <div class="card-body">
            <div class="row">

                <div class="col-6 mx-auto">
                    <div class="row mb-4 mx-auto">
                        <div class="col mx-auto">
                            <button id="expand" class="btn btn-sm btn-primary float-right">Toggle Expand/Collapse All</button>
                        </div>

                    </div>
                    <div id="tree" class="bstreeview"></div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('css')
    <style>
        /*
        @preserve
        bstreeview.css
        Version: 1.2.0
        Authors: Sami CHNITER
        <sami.chniter@gmail.com>
        Copyright 2020
        License: Apache License 2.0
        Project: https://github.com/chniter/bstreeview
        */
        .bstreeview {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
            padding: 0;
            overflow: hidden
        }

        .bstreeview .list-group {
            margin-bottom: 0
        }

        .bstreeview .list-group-item {
            border-radius: 0;
            border-width: 1px 0 0 0;
            padding-top: .5rem;
            padding-bottom: .5rem;
            cursor: pointer;
            color: black;
        }

        .bstreeview .list-group-item:hover {
            background-color: #dee2e6
        }

        .bstreeview > .list-group-item:first-child {
            border-top-width: 0
        }

        .bstreeview .state-icon {
            margin-right: 8px
        }

        .bstreeview .item-icon {
            margin-right: 5px
        }

        .bstreeview a {
            color: green;
            text-decoration: underline;
        }
    </style>
@endsection
@section('js')

    <script>
        /*
 @preserve
 bstreeview.js
 Version: 1.2.0
 Authors: Sami CHNITER <sami.chniter@gmail.com>
 Copyright 2020
 License: Apache License 2.0
 Project: https://github.com/chniter/bstreeview
*/
        !function (t, e, i, s) {
            "use strict";
            var n = {
                    expandIcon: "fa fa-angle-down fa-fw",
                    collapseIcon: "fa fa-angle-right fa-fw",
                    indent: 1.25,
                    parentsMarginLeft: "1.25rem",
                    openNodeLinkOnNewTab: !0
                }, a = '<div role="treeitem" class="list-group-item" data-toggle="collapse"></div>',
                d = '<div role="group" class="list-group collapse" id="itemid"></div>',
                o = '<i class="state-icon"></i>', r = '<i class="item-icon"></i>';

            function l(e, i) {
                this.element = e, this.itemIdPrefix = e.id + "-item-", this.settings = t.extend({}, n, i), this.init()
            }

            t.extend(l.prototype, {
                init: function () {
                    this.tree = [], this.nodes = [], this.settings.data && (this.settings.data.isPrototypeOf(String) && (this.settings.data = t.parseJSON(this.settings.data)), this.tree = t.extend(!0, [], this.settings.data), delete this.settings.data), t(this.element).addClass("bstreeview"), this.initData({nodes: this.tree});
                    var i = this;
                    this.build(t(this.element), this.tree, 0), t(this.element).on("click", ".list-group-item", function (s) {
                        t(".state-icon", this).toggleClass(i.settings.expandIcon).toggleClass(i.settings.collapseIcon), s.target.hasAttribute("href") && (i.settings.openNodeLinkOnNewTab ? e.open(s.target.getAttribute("href"), "_blank") : e.location = s.target.getAttribute("href"))
                    })
                }, initData: function (e) {
                    if (e.nodes) {
                        var i = e, s = this;
                        t.each(e.nodes, function (t, e) {
                            e.nodeId = s.nodes.length, e.parentId = i.nodeId, s.nodes.push(e), e.nodes && s.initData(e)
                        })
                    }
                }, build: function (e, i, s) {
                    var n = this, l = n.settings.parentsMarginLeft;
                    s > 0 && (l = (n.settings.indent + s * n.settings.indent).toString() + "rem;"), s += 1, t.each(i, function (i, g) {
                        var h = t(a).attr("data-target", "#" + n.itemIdPrefix + g.nodeId).attr("style", "padding-left:" + l).attr("aria-level", s);
                        if (g.nodes) {
                            var c = t(o).addClass(n.settings.collapseIcon);
                            h.append(c)
                        }
                        if (g.icon) {
                            var f = t(r).addClass(g.icon);
                            h.append(f)
                        }
                        if (h.append(g.text), g.href && h.attr("href", g.href), g.class && h.addClass(g.class), g.id && h.attr("id", g.id), e.append(h), g.nodes) {
                            var p = t(d).attr("id", n.itemIdPrefix + g.nodeId);
                            e.append(p), n.build(p, g.nodes, s)
                        }
                    })
                }
            }), t.fn.bstreeview = function (e) {
                return this.each(function () {
                    t.data(this, "plugin_bstreeview") || t.data(this, "plugin_bstreeview", new l(this, e))
                })
            }
        }(jQuery, window, document);
    </script>
    <script>
        $(document).ready(function () {
            var data = {!! json_encode($data) !!};


            $('#tree').bstreeview({
                data: data,
                collapseIcon: 'mdi mdi-chevron-right',
                expandIcon: 'mdi mdi-chevron-up',
                indent: 1.25,
                parentsMarginLeft: '1.25rem',
                openNodeLinkOnNewTab: true
            });
            // collapses all nodes

            $('.list-group-item').each(function (e, i) {
                var attr = $(i).attr('href');

                // For some browsers, `attr` is undefined; for others,
                // `attr` is false.  Check for both.
                if (typeof attr !== typeof undefined && attr !== false) {
                    $(i).addClass('text-primary font-weight-bold')
                    $(i).css('text-decoration', 'underline')
                    // $(i).appendChild('<i class="mdi mdi-pencil"></i>');
                }
            })
            $('#expand').on('click', function () {
                $('.list-group-item').each(function (e, i) {
                    var attr = $(i).attr('href');


                    // For some browsers, `attr` is undefined; for others,
                    // `attr` is false.  Check for both.
                    if (typeof attr !== typeof undefined && attr !== false) {
                        $(i).addClass('text-primary font-weight-bold')
                        $(i).css('text-decoration', 'underline')
                        // $(i).appendChild('<i class="mdi mdi-pencil"></i>');
                    }else{
                        $(i).click()
                    }
                })
            })
            $('#collapse').on('click', function () {

            })

        })
    </script>

@endsection
