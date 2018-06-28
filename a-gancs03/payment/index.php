<?php
/**
 * Created by PhpStorm.
 * User: empty
 * Date: 2018/6/12
 * Time: 下午4:16
 */

header('Content-Type: application/json; charset=UTF-8');

include_once '../../include/config.php';
include_once '../../database/mysql.config.php';
include_once '../common/login_check.php';
include_once '../../class/admin.php';
check_quanxian('cwgl');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>充值管理</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/element-ui@2.2.0/lib/theme-chalk/index.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.18.0/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/element-ui@2.2.0/lib/index.min.js"></script>
    <style type="text/css">
        .element-payment .el-tags {
            margin-top: -5px;
        }

        .element-payment .el-tags .el-tag {
            margin-right: 10px;
            margin-top: 5px;
        }

        .element-payment .el-checkbox-group .el-checkbox {
            float: left;
            /*width: 25%;*/
            /*padding-right: 20px;*/
            margin: 0 20px 0 0;
            padding: 0;
        }

        .element-payment .el-checkbox-group .el-checkbox:last-child {
            margin: 0;
        }

        .element-payment .el-form-item > label {
            float: none;
        }

        .element-payment .el-form-switch {
            line-height: 28px;
        }

        .element-payment .el-form-input {
            padding-top: 5px;
        }

        .element-payment .el-forms {
            font-size: 0;
            /*border-top: 1px #e4e7ed solid;*/
            margin-top: 15px;
        }

        .element-payment .el-forms label {
            width: 90px;
            color: #99a9bf;
        }

        .element-payment .el-forms .el-form-item {
            margin-right: 0;
            margin-bottom: 0;
            width: 50%;
        }
    </style>
</head>
<body>
<div id="app" class="element-payment">
    <el-container>
        <el-main>
            <el-tabs v-model="activeName">
                <el-tab-pane label="通道列表" name="list">
                    <el-table v-bind:data="apiData.list" stripe="true" style="width: 100%"
                              v-loading="button.loading">
                        <el-table-column prop="id" label="#" width="100"></el-table-column>
                        <el-table-column prop="name" label="通道名称" width="180"></el-table-column>
                        <el-table-column prop="support" label="支持类型">
                            <template slot-scope="scope">
                                <div class="el-tags">
                                    <el-tag v-for="(v, k) in scope.row.support"
                                            v-bind:key="k">{{types[v] === undefined ? v : types[v]}}
                                    </el-tag>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column fixed="right" label="操作" width="315">
                            <template slot-scope="scope">
                                <el-button v-on:click="api().add(scope.row)" type="primary"
                                           size="mini">添加商户
                                </el-button>
                                <el-button v-on:click="api().closeAll(scope.row)" type="danger"
                                           size="mini">一键停用
                                </el-button>
                                <el-button v-on:click="api().token(scope.row)" type="danger"
                                           size="mini">更换 Token
                                </el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-tab-pane>
                <el-tab-pane label="商户列表" name="config">
                    <el-table v-bind:data="configData.list" stripe="true" style="width: 100%"
                              v-loading="button.loading">
                        <el-table-column prop="id" label="#" width="100"></el-table-column>
                        <el-table-column prop="name" label="通道名称" width="180"></el-table-column>
                        <el-table-column prop="display" label="前台显示" width="180"></el-table-column>
                        <el-table-column prop="remark" label="后台备注"></el-table-column>
                        <el-table-column fixed="right" label="状态" width="80">
                            <template slot-scope="scope">
                                <el-switch v-model="scope.row.activate"
                                           v-on:change="config().change(scope.$index)"></el-switch>
                            </template>
                        </el-table-column>
                        <el-table-column fixed="right" label="操作" width="385">
                            <template slot-scope="scope">
                                <el-button v-on:click="config().group('edit', scope.$index)"
                                           size="mini">修改会员组
                                </el-button>
                                <el-button v-on:click="config().support('edit', scope.$index)"
                                           size="mini">修改类型
                                </el-button>
                                <el-button v-on:click="config().extend('edit', scope.$index)"
                                           size="mini">修改信息
                                </el-button>
                                <el-button v-on:click="config().delete(scope.$index)" type="danger"
                                           size="mini">删除
                                </el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-tab-pane>
                <el-tab-pane label="订单查询" name="order">
                    <el-row>
                        <el-col>
                            <el-input placeholder="请输入商户订单号" v-bind:disabled="button.loading" v-model="orderData.id">
                                <el-button slot="append"
                                           v-bind:icon="button.loading ? 'el-icon-loading' : 'el-icon-search'"
                                           v-bind:disabled="button.loading"
                                           v-on:click="order().get()">查询
                                </el-button>
                            </el-input>
                        </el-col>
                        <el-col v-if="orderData.order.id !== undefined">
                            <el-form label-position="left" inline class="el-forms" v-loading="button.loading">
                                <el-form-item label="商户订单">
                                    <span>{{orderData.order.order_id}}</span>
                                </el-form-item>
                                <el-form-item label="网站订单">
                                    <span>{{orderData.order.web_id}}</span>
                                </el-form-item>
                                <el-form-item label="订单金额">
                                    <span>{{orderData.order.amount}}</span>
                                </el-form-item>
                                <el-form-item label="订单类型">
                                    <span>{{types[orderData.order.type] === undefined ? orderData.order.type : types[orderData.order.type]}}</span>
                                </el-form-item>
                                <el-form-item label="创建时间">
                                    <span>{{orderData.order.created}}</span>
                                </el-form-item>
                                <el-form-item label="更新时间">
                                    <span>{{orderData.order.updated}}</span>
                                </el-form-item>
                                <el-form-item label="订单状态">
                                    <span>{{orderData.order.status ? '已完成' : orderData.order.expired ? '已过期' : '未完成或未接收到完成通知'}}</span>
                                </el-form-item>
                                <el-form-item label="通知状态">
                                    <span>{{orderData.order.notice ? '已通知' : '订单未完成或通知失败'}}</span>
                                </el-form-item>
                                <el-form-item label="通道编号">
                                    <span>{{orderData.order.payment_id}}</span>
                                </el-form-item>
                                <el-form-item label="商户编号">
                                    <span>{{orderData.order.config_id}}</span>
                                </el-form-item>
                                <el-form-item label="会员账号">
                                    <span>{{orderData.order.username}}</span>
                                </el-form-item>
                                <el-form-item label="会员编号">
                                    <span>{{orderData.order.uid}}</span>
                                </el-form-item>
                            </el-form>
                        </el-col>
                    </el-row>
                </el-tab-pane>
            </el-tabs>
        </el-main>
        <el-footer v-if="activeName === 'list'">
            <el-button type="primary" v-bind:icon="button.icon" v-bind:disabled="button.loading"
                       v-on:click="api().list('refresh')">更新列表
            </el-button>
        </el-footer>
        <el-footer v-if="activeName === 'config'">
            <el-button type="primary" v-bind:icon="button.icon" v-bind:disabled="button.loading"
                       v-on:click="config().list(true)">刷新列表
            </el-button>
        </el-footer>
        <el-footer v-if="activeName === 'order' && orderData.order.id !== undefined">
            <el-button type="primary" v-bind:icon="button.icon"
                       v-bind:disabled="button.loading || orderData.order.status || orderData.order.expired"
                       v-on:click="order().update()">更新状态
            </el-button>
            <el-button type="primary" v-bind:icon="button.loading ? 'el-icon-loading' : 'el-icon-message'"
                       v-bind:disabled="button.loading || !orderData.order.status || orderData.order.notice || orderData.order.expired"
                       v-on:click="order().notify()">发起通知
            </el-button>
        </el-footer>
    </el-container>
    <el-dialog title="添加商户" v-bind:visible.sync="apiData.dialog" v-bind:before-close="api().close">
        <el-form v-model="apiData.form" v-loading="button.loading">
            <el-form-item label="通道名称">
                <el-input v-model="apiData.form.name" readonly="readonly"></el-input>
            </el-form-item>
            <el-form-item label="前台显示">
                <el-input v-model="apiData.form.display" auto-complete="off"
                          v-bind:placeholder="apiData.form.name"></el-input>
            </el-form-item>
            <el-form-item label="后台备注">
                <el-input v-model="apiData.form.remark" auto-complete="off"
                          v-bind:placeholder="apiData.form.name"></el-input>
            </el-form-item>
            <!-- <el-form-item label="启用类型" v-if="false">
                <el-checkbox-group v-model="apiData.form.support">
                    <el-checkbox v-bind:label="v" name="support" v-for="(v, k) in apiData.support" v-bind:key="k">
                        {{types[v] === undefined ? v : types[v]}}
                    </el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item label="启用会员组" v-if="false">
                <el-row>
                    <el-col class="el-form-switch" v-for="(v, k) in groups" v-bind:key="k">
                        <el-switch v-model="apiData.form.groups[k]" v-bind:active-text="v"></el-switch>
                    </el-col>
                </el-row>
            </el-form-item> -->
            <el-form-item v-bind:label="item.name" v-for="(item, key) in apiData.forms" v-bind:key="key">
                <el-input v-model="apiData.form.extend[key]" auto-complete="off" v-if="item.tag === 'input'"
                          v-bind:type="item.type"></el-input>
                <el-switch v-model="apiData.form.extend[key]" v-if="item.tag === 'switch'"></el-switch>
                <el-select v-model="apiData.form.extend[key]" v-if="item.tag === 'select'"
                           v-bind:placeholder="'请选择' + item.name">
                    <el-option v-bind:label="v" v-bind:value="k" v-for="(v, k) in item.options"
                               v-bind:key="k"></el-option>
                </el-select>
                <el-checkbox-group v-model="apiData.form.extend[key]" v-if="item.tag === 'checkbox'">
                    <el-checkbox v-bind:label="k" v-bind:name="key" v-for="(v, k) in item.options"
                                 v-bind:key="k">{{v}}
                    </el-checkbox>
                </el-checkbox-group>
                <el-radio-group v-model="apiData.form.extend[key]" v-if="item.tag === 'radio'">
                    <el-radio v-bind:label="k" v-bind:name="key" v-for="(v, k) in item.options"
                              v-bind:key="k">{{v}}
                    </el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button v-on:click="api().close()" v-bind:disabled="button.loading">取 消</el-button>
            <el-button type="primary" v-bind:disabled="button.loading"
                       v-on:click="api().submit()">确 定
            </el-button>
        </div>
    </el-dialog>
    <el-dialog v-bind:title="configData.title" v-bind:visible.sync="configData.dialog.group">
        <el-form v-model="configData.form" v-loading="button.loading">
            <el-form-item label="后台备注">
                <el-input v-model="configData.form.remark" readonly="readonly"></el-input>
            </el-form-item>
            <el-form-item label="修改会员组">
                <el-row>
                    <el-col class="el-form-switch" v-for="(v, k) in groups" v-bind:key="k">
                        <el-switch v-model="configData.form.groups[k]" v-bind:active-text="v"></el-switch>
                    </el-col>
                </el-row>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button v-on:click="config().group('close')" v-bind:disabled="button.loading">取 消</el-button>
            <el-button type="primary" v-bind:disabled="button.loading"
                       v-on:click="config().group('submit', configData.index)">确 定
            </el-button>
        </div>
    </el-dialog>
    <el-dialog v-bind:title="configData.title" v-bind:visible.sync="configData.dialog.support">
        <el-form v-model="configData.form" v-loading="button.loading">
            <el-form-item label="后台备注">
                <el-input v-model="configData.form.remark" readonly="readonly"></el-input>
            </el-form-item>
            <el-form-item v-bind:label="types[k] === undefined ? k : types[k]" v-for="(v, k) in configData.form.support"
                          v-bind:key="k">
                <el-row>
                    <el-col class="el-form-switch">
                        <el-switch v-model="v.web" active-text="电脑端开启"></el-switch>
                    </el-col>
                    <el-col class="el-form-switch">
                        <el-switch v-model="v.mobile" active-text="手机端开启"></el-switch>
                    </el-col>
                    <el-col class="el-form-input">
                        <el-input v-model="v.display" v-bind:placeholder="configData.form.display">
                            <template slot="prepend">前台显示</template>
                        </el-input>
                    </el-col>
                    <el-col class="el-form-input">
                        <el-input v-model="v.fee" v-bind:placeholder="0">
                            <template slot="prepend">类型费率</template>
                            <template slot="append">%（百分比）</template>
                        </el-input>
                    </el-col>
                </el-row>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button v-on:click="config().support('close')" v-bind:disabled="button.loading">取 消</el-button>
            <el-button type="primary" v-bind:disabled="button.loading"
                       v-on:click="config().support('submit', configData.index)">确 定
            </el-button>
        </div>
    </el-dialog>
    <el-dialog v-bind:title="configData.title" v-bind:visible.sync="configData.dialog.extend"
               v-bind:before-close="config().extend('close')">
        <el-form v-model="configData.form" v-loading="button.loading">
            <el-form-item label="通道名称">
                <el-input v-model="configData.form.name" readonly="readonly"></el-input>
            </el-form-item>
            <el-form-item label="前台显示">
                <el-input v-model="configData.form.display" auto-complete="off"
                          v-bind:placeholder="configData.form.name"></el-input>
            </el-form-item>
            <el-form-item label="后台备注">
                <el-input v-model="configData.form.remark" auto-complete="off"
                          v-bind:placeholder="configData.form.name"></el-input>
            </el-form-item>
            <el-form-item v-bind:label="item.name" v-for="(item, key) in configData.forms" v-bind:key="key">
                <el-input v-model="configData.form.extend[key]" auto-complete="off" v-if="item.tag === 'input'"
                          v-bind:type="item.type"></el-input>
                <el-switch v-model="configData.form.extend[key]" v-if="item.tag === 'switch'"></el-switch>
                <el-select v-model="configData.form.extend[key]" v-if="item.tag === 'select'"
                           v-bind:placeholder="'请选择' + item.name">
                    <el-option v-bind:label="v" v-bind:value="k" v-for="(v, k) in item.options"
                               v-bind:key="k"></el-option>
                </el-select>
                <el-checkbox-group v-model="configData.form.extend[key]" v-if="item.tag === 'checkbox'">
                    <el-checkbox v-bind:label="k" v-bind:name="key" v-for="(v, k) in item.options"
                                 v-bind:key="k">{{v}}
                    </el-checkbox>
                </el-checkbox-group>
                <el-radio-group v-model="configData.form.extend[key]" v-if="item.tag === 'radio'">
                    <el-radio v-bind:label="k" v-bind:name="key" v-for="(v, k) in item.options"
                              v-bind:key="k">{{v}}
                    </el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button v-on:click="config().extend('close')()" v-bind:disabled="button.loading">取 消</el-button>
            <el-button type="primary" v-bind:disabled="button.loading"
                       v-on:click="config().extend('submit', configData.index)">确 定
            </el-button>
        </div>
    </el-dialog>
</div>
<script type="text/javascript">
    new Vue({
        el: "#app",
        watch: {
            activeName: function (name) {
                if (name === 'config' && !this.configData.update) {
                    this.config().list()
                }
            },
            "button.loading": function (loading) {
                if (loading) {
                    this.button.icon = "el-icon-loading";
                } else {
                    this.button.icon = "el-icon-refresh";
                }
            },
            "apiData.form": {
                handler: function () {
                    this.changed = true
                },
                deep: true
            },
            "apiData.dialog": function () {
                this.changed = false
            },
            "configData.form": {
                handler: function () {
                    this.changed = true
                },
                deep: true
            },
            "configData.dialog.extend": function () {
                this.changed = false
            }
        },
        data: function () {
            return {
                changed: false,
                activeName: "list",
                dialogFormVisible: true,
                button: {
                    icon: "el-icon-refresh",
                    loading: false
                },
                types: {},
                groups: {},
                apiData: {
                    list: [],
                    form: {
                        groups: {},
                        extend: {}
                    },
                    forms: {},
                    support: {},
                    dialog: false
                },
                configData: {
                    update: false,
                    list: [],
                    form: {
                        groups: {},
                        support: {},
                        extend: {}
                    },
                    forms: {},
                    dialog: {
                        group: false,
                        support: false,
                        extend: false
                    },
                    index: 0,
                    title: ''
                },
                orderData: {
                    order: {},
                    id: ''
                }
            };
        },
        methods: {
            api: function () {
                let t = this;
                return {
                    add: function (row) {
                        t.apiData.form = {};
                        t.$set(t.apiData.form, 'id', row.id);
                        t.$set(t.apiData.form, 'name', row.name);
                        t.$set(t.apiData.form, 'remark', null);
                        t.$set(t.apiData.form, 'display', null);
                        t.$set(t.apiData.form, 'support', []);
                        t.$set(t.apiData.form, 'groups', {});
                        t.$set(t.apiData.form, 'extend', {});
                        t.apiData.support = row.support;
                        t.apiData.forms = {};
                        Object.keys(row.forms).map(function (key) {
                            t.extend(key, row.forms[key], 'apiData');
                        });
                        t.apiData.dialog = true
                    },
                    close: function () {
                        if (t.button.loading) {
                            return false;
                        } else {
                            if (t.changed) {
                                t.$confirm('确定要关闭窗口？已编辑的信息将丢失', '提示', {
                                    confirmButtonText: '确定',
                                    cancelButtonText: '取消',
                                    type: 'warning'
                                }).then(function () {
                                    t.apiData.dialog = false
                                }).catch(function () {
                                })
                            } else {
                                t.apiData.dialog = false
                            }
                        }
                    },
                    submit: function () {
                        t.button.loading = true;
                        axios({
                            method: "POST",
                            url: "ajax.php",
                            data: {
                                model: "config",
                                action: "add",
                                data: {
                                    id: t.apiData.form.id,
                                    display: t.apiData.form.display,
                                    remark: t.apiData.form.remark,
                                    support: t.apiData.form.support,
                                    groups: t.apiData.form.groups,
                                    extend: t.apiData.form.extend
                                }
                            }
                        }).then(function (res) {
                            t.button.loading = false;
                            if (res.data) {
                                if (res.data.code === 200) {
                                    t.$message({
                                        type: 'success',
                                        message: '添加成功'
                                    });
                                    t.apiData.dialog = false;
                                    t.configData.update = false;
                                } else {
                                    t.$alert(res.data.message, '添加失败', {
                                        type: 'error'
                                    });
                                }
                            }
                        }).catch(function () {
                            t.button.loading = false;
                            t.$alert('系统发生错误，请重试', '添加失败', {
                                type: 'error'
                            });
                        })
                    },
                    list: function (action) {
                        t.button.loading = true;
                        axios({
                            method: "POST",
                            url: "ajax.php",
                            data: {
                                model: "api",
                                action: action
                            }
                        }).then(function (res) {
                            t.button.loading = false;
                            if (res.data) {
                                if (res.data.code === 200) {
                                    action !== 'cache' && t.$notify({
                                        title: '更新成功',
                                        message: '已更新通道为最新列表',
                                        type: 'success'
                                    });
                                    t.apiData.list = res.data.message;
                                } else {
                                    action !== 'cache' && t.$notify({
                                        title: '更新失败',
                                        message: res.data.message,
                                        type: 'error'
                                    });
                                }
                            }
                        }).catch(function () {
                            t.button.loading = false;
                            t.$notify({
                                title: '系统错误',
                                message: '系统发生错误，请刷新页面重试',
                                type: 'error'
                            });
                        });
                    },
                    token: function (row) {
                        t.$confirm('继续更换将导致正在付款的订单无法自动到账', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            type: 'warning'
                        }).then(function () {
                            t.button.loading = true;
                            axios({
                                method: "POST",
                                url: "ajax.php",
                                data: {
                                    model: "api",
                                    action: 'token',
                                    data: {
                                        id: row.id
                                    }
                                }
                            }).then(function (res) {
                                t.button.loading = false;
                                if (res.data) {
                                    if (res.data.code === 200) {
                                        t.$message({
                                            type: 'success',
                                            message: 'Token 更换成功'
                                        });
                                    } else {
                                        t.$alert(res.data.message, '更换失败', {
                                            type: 'error'
                                        });
                                    }
                                }
                            }).catch(function () {
                                t.button.loading = false;
                                t.$alert('系统发生错误，请重试', '更换失败', {
                                    type: 'error'
                                });
                            });
                        }).catch(function () {
                        });
                    },
                    closeAll: function (row) {
                        t.$confirm('确定要停用该通道的全部商户？', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            type: 'warning'
                        }).then(function () {
                            t.button.loading = true;
                            axios({
                                method: "POST",
                                url: "ajax.php",
                                data: {
                                    model: "api",
                                    action: 'close',
                                    data: {
                                        id: row.id
                                    }
                                }
                            }).then(function (res) {
                                t.button.loading = false;
                                if (res.data) {
                                    if (res.data.code === 200) {
                                        t.$message({
                                            type: 'success',
                                            message: '已停用 #' + row.id + ' ' + row.name + ' 的全部商户'
                                        });
                                        t.configData.update = false;
                                    } else {
                                        t.$alert(res.data.message, '停用失败', {
                                            type: 'error'
                                        });
                                    }
                                }
                            }).catch(function () {
                                t.button.loading = false;
                                t.$alert('系统发生错误，请重试', '停用失败', {
                                    type: 'error'
                                });
                            });
                        }).catch(function () {
                        });
                    }
                };
            },
            config: function () {
                let t = this;
                return {
                    list: function (notify) {
                        t.configData.update = true;
                        t.button.loading = true;
                        axios({
                            method: "POST",
                            url: "ajax.php",
                            data: {
                                model: "config",
                                action: "list"
                            }
                        }).then(function (res) {
                            t.button.loading = false;
                            if (res.data) {
                                if (res.data.code === 200) {
                                    t.configData.list = res.data.message
                                    notify && t.$message({
                                        type: 'success',
                                        message: '刷新成功'
                                    });
                                } else {
                                    notify && t.$alert(res.data.message, '刷新失败', {
                                        type: 'error'
                                    });
                                }
                            }
                        }).catch(function () {
                            t.button.loading = false;
                            notify && t.$alert('系统发生错误，请重试', '刷新失败', {
                                type: 'error'
                            });
                        });
                    },
                    group: function (action, index) {
                        let row = t.configData.list[index ? index : 0];
                        switch (action) {
                            case 'edit':
                                t.configData.index = index;
                                t.configData.title = '#' + row.id + ' ' + row.name;
                                t.button.loading = true;
                                t.$set(t.configData.form, 'remark', row.remark);
                                t.config().action('group', {type: 'list', id: row.id}, null, function (res) {
                                    t.$set(t.configData.form, 'groups', res.data.message.length === undefined ? res.data.message : {});
                                    t.button.loading = false;
                                    t.configData.dialog.group = true
                                }, function () {
                                    t.button.loading = false;
                                }, true);
                                break;
                            case 'close':
                                t.configData.dialog.group = false;
                                break;
                            case 'submit':
                                let title = '修改会员组 #' + row.id + ' ' + row.name;
                                t.button.loading = true;
                                t.config().action('group', {
                                    id: row.id,
                                    type: 'save',
                                    groups: t.configData.form.groups
                                }, title, function () {
                                    t.button.loading = false;
                                    t.configData.dialog.group = false
                                }, function () {
                                    t.button.loading = false;
                                });
                                break;
                        }
                    },
                    support: function (action, index) {
                        let row = t.configData.list[index ? index : 0];
                        switch (action) {
                            case 'edit':
                                t.configData.index = index;
                                t.configData.title = '#' + row.id + ' ' + row.name;
                                t.$set(t.configData.form, 'remark', row.remark);
                                t.$set(t.configData.form, 'display', row.display);
                                t.$set(t.configData.form, 'support', {});
                                JSON.parse(JSON.stringify(t.apiData.list)).map(function (v) {
                                    if (v.id === row.payment_id) {
                                        return v.support.map(function (v) {
                                            t.$set(t.configData.form.support, v, {
                                                web: row.support[v] === undefined ? false : row.support[v].web,
                                                mobile: row.support[v] === undefined ? false : row.support[v].mobile,
                                                display: row.support[v] === undefined ? '' : row.support[v].display,
                                                fee: row.support[v] === undefined ? '0' : row.support[v].fee
                                            });
                                        });
                                    }
                                });
                                t.configData.dialog.support = true;
                                break;
                            case 'close':
                                t.configData.dialog.support = false;
                                break;
                            case 'submit':
                                let title = '修改类型 #' + row.id + ' ' + row.name;
                                t.button.loading = true;
                                t.config().action('support', {
                                    id: row.id,
                                    support: t.configData.form.support
                                }, title, function () {
                                    row.support = t.configData.form.support;
                                    t.button.loading = false;
                                    t.configData.dialog.support = false
                                }, function () {
                                    t.button.loading = false;
                                });
                                break;
                        }
                    },
                    extend: function (action, index) {
                        let row = t.configData.list[index ? index : 0];
                        switch (action) {
                            case 'edit':
                                t.configData.index = index;
                                t.configData.title = '#' + row.id + ' ' + row.name;
                                t.configData.forms = {};
                                t.$set(t.configData.form, 'name', row.name);
                                t.$set(t.configData.form, 'display', row.display);
                                t.$set(t.configData.form, 'remark', row.remark);
                                t.$set(t.configData.form, 'extend', {});
                                JSON.parse(JSON.stringify(t.apiData.list)).map(function (v) {
                                    if (v.id === row.payment_id) {
                                        return Object.keys(v.forms).map(function (k) {
                                            t.extend(k, v.forms[k], 'configData');
                                        });
                                    }
                                });
                                Object.keys(row.extend).map(function (k) {
                                    if (t.configData.forms[k] !== undefined) {
                                        return t.$set(t.configData.form.extend, k, row.extend[k]);
                                    }
                                });
                                t.configData.dialog.extend = true;
                                break;
                            case 'close':
                                return function () {
                                    if (t.button.loading) {
                                        return false;
                                    } else {
                                        if (t.changed) {
                                            t.$confirm('确定要关闭窗口？已编辑的信息将丢失', '提示', {
                                                confirmButtonText: '确定',
                                                cancelButtonText: '取消',
                                                type: 'warning'
                                            }).then(function () {
                                                t.configData.dialog.extend = false
                                            }).catch(function () {
                                            })
                                        } else {
                                            t.configData.dialog.extend = false
                                        }
                                    }
                                };
                            case 'submit':
                                let title = '修改信息 #' + row.id + ' ' + row.name;
                                t.button.loading = true;
                                t.config().action('save', {
                                    id: row.id,
                                    name: t.configData.form.name,
                                    display: t.configData.form.display,
                                    remark: t.configData.form.remark,
                                    extend: t.configData.form.extend
                                }, title, function () {
                                    row.name = t.configData.form.name;
                                    row.display = t.configData.form.display;
                                    row.remark = t.configData.form.remark;
                                    row.extend = t.configData.form.extend;
                                    t.button.loading = false;
                                    t.configData.dialog.extend = false
                                }, function () {
                                    t.button.loading = false;
                                });
                                break;
                        }
                    },
                    change: function (index) {
                        let row = t.configData.list[index];
                        let title = (row.activate ? '启用' : '停用') + ' #' + row.id + ' ' + row.name;
                        let func = function () {
                            t.config().action('change', {
                                id: row.id,
                                activate: row.activate
                            }, title, null, function () {
                                row.activate = !row.activate;
                            })
                        };
                        if (row.activate) {
                            func();
                        } else {
                            t.$confirm('确定' + title + '？', '提示', {
                                confirmButtonText: '确定',
                                cancelButtonText: '取消',
                                type: 'warning'
                            }).then(function () {
                                func();
                            }).catch(function () {
                                row.activate = true;
                            });
                        }
                    },
                    delete: function (index) {
                        let row = t.configData.list[index];
                        let title = '删除 #' + row.id + ' ' + row.name;
                        t.$confirm('确定' + title + '？删除后将不能恢复', '提示', {
                            confirmButtonText: '确定',
                            cancelButtonText: '取消',
                            type: 'warning'
                        }).then(function () {
                            t.button.loading = true;
                            t.config().action('delete', {id: row.id}, title, function () {
                                t.button.loading = false;
                                t.configData.list.splice(index, 1);
                            }, function () {
                                t.button.loading = false;
                            })
                        }).catch(function () {
                        });
                    },
                    action: function (action, data, title, success, error, notify) {
                        if (typeof success !== 'function') {
                            success = function () {
                            }
                        }
                        if (typeof error !== 'function') {
                            error = function () {
                            }
                        }
                        axios({
                            method: "POST",
                            url: "ajax.php",
                            data: {
                                model: "config",
                                action: action,
                                data: data
                            }
                        }).then(function (res) {
                            if (res.data) {
                                if (res.data.code === 200) {
                                    !notify && t.$message({
                                        type: 'success',
                                        message: title + ' 成功'
                                    });
                                    success(res);
                                } else {
                                    !notify && t.$notify({
                                        title: title + ' 失败',
                                        message: res.data.message,
                                        type: 'error'
                                    });
                                    error(res);
                                }
                            }
                        }).catch(function (res) {
                            !notify && t.$alert('系统发生错误，请重试', title + ' 失败', {
                                type: 'error'
                            });
                            error(res);
                        });
                    }
                }
            },
            order: function () {
                let t = this;
                return {
                    get: function () {
                        t.button.loading = true;
                        axios({
                            method: "POST",
                            url: "ajax.php",
                            data: {
                                model: "order",
                                action: "get",
                                data: {
                                    order_id: t.orderData.id
                                }
                            }
                        }).then(function (res) {
                            t.button.loading = false;
                            if (res.data) {
                                if (res.data.code === 200) {
                                    t.orderData.order = res.data.message
                                } else {
                                    t.$alert(res.data.message, '查询失败', {
                                        type: 'error'
                                    });
                                }
                            }
                        }).catch(function () {
                            t.button.loading = false;
                            t.$alert('查询订单信息失败，请重试', '查询失败', {
                                type: 'error'
                            });
                        });
                    },
                    update: function () {
                        t.button.loading = true;
                        axios({
                            method: "POST",
                            url: "ajax.php",
                            data: {
                                model: "order",
                                action: "update",
                                data: {
                                    order_id: t.orderData.order.order_id
                                }
                            }
                        }).then(function (res) {
                            t.button.loading = false;
                            if (res.data) {
                                if (res.data.code === 200) {
                                    if (res.data.message) {
                                        t.orderData.order.status = true;
                                        t.$message({
                                            type: 'success',
                                            message: '订单状态更新成功'
                                        });
                                    } else {
                                        t.$alert('订单未完成或者通道不支持查询订单状态', '更新失败', {
                                            type: 'error'
                                        });
                                    }
                                } else {
                                    t.$alert(res.data.message, '更新失败', {
                                        type: 'error'
                                    });
                                }
                            }
                        }).catch(function () {
                            t.button.loading = false;
                            t.$alert('更新订单状态失败，请重试', '更新失败', {
                                type: 'error'
                            });
                        });
                    },
                    notify: function () {
                        t.button.loading = true;
                        axios({
                            method: "POST",
                            url: "ajax.php",
                            data: {
                                model: "order",
                                action: "notify",
                                data: {
                                    order_id: t.orderData.order.order_id
                                }
                            }
                        }).then(function (res) {
                            t.button.loading = false;
                            if (res.data) {
                                if (res.data.code === 200) {
                                    if (res.data.message) {
                                        t.$message({
                                            type: 'success',
                                            message: '发起订单通知成功'
                                        });
                                    } else {
                                        t.$message({
                                            type: 'error',
                                            message: '发起订单通知失败'
                                        });
                                    }
                                } else {
                                    t.$alert(res.data.message, '通知失败', {
                                        type: 'error'
                                    });
                                }
                            }
                        }).catch(function () {
                            t.button.loading = false;
                            t.$alert('发起订单通知失败，请重试', '通知失败', {
                                type: 'error'
                            });
                        });
                    }
                }
            },
            extend: function (key, item, name) {
                let t = this;
                let result = JSON.parse(JSON.stringify(item)); // 深度复制
                switch (true) {
                    case typeof result !== 'object':
                    case result.tag === undefined:
                    case result.name === undefined:
                        result = false;
                        break;
                    case result.tag === 'textarea':
                    case result.tag === 'input':
                        t.$set(t[name].form.extend, key, typeof result.default === 'string' ? result.default : null);
                        if (result.tag === 'textarea') {
                            result.tag = 'input';
                            result.type = 'textarea';
                        } else if (result.type !== 'password') {
                            result.type = 'text';
                        }
                        t.$set(t[name].forms, key, result);
                        break;
                    case result.tag === 'switch':
                        t.$set(t[name].form.extend, key, result.default === true);
                        t.$set(t[name].forms, key, result);
                        break;
                    case result.tag === 'select':
                    case result.tag === 'checkbox':
                    case result.tag === 'radio':
                        if (result.options === undefined || Object.keys(result.options).length <= 0) {
                            result = false
                        } else {
                            if (result.tag === 'checkbox') {
                                if (result.default === undefined || result.default.length === undefined) {
                                    result.default = []
                                }
                            } else {
                                result.default = typeof result.default === 'string' ? result.default : null
                            }
                            t.$set(t[name].form.extend, key, result.default);
                            t.$set(t[name].forms, key, result);
                        }
                        break;
                    default:
                        result = false;
                        break;
                }
                return result;
            }
        },
        created: function () {
            let t = this;
            axios({
                method: "POST",
                url: "ajax.php",
                data: {
                    model: "common",
                    action: "config"
                }
            }).then(function (res) {
                if (res.data) {
                    if (res.data.code === 200) {
                        t.types = res.data.message.types
                        t.groups = res.data.message.groups
                    }
                }
            }).catch(function () {
            });
            t.api().list('cache');
        }
    });
</script>
</body>
</html>