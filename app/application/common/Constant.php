<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 18:51
 */

namespace app\common;

/**
 * Class Constant 公共常量类
 *
 * @package app\common
 */
class Constant
{
    const USER_NOT_LOGIN = '账号无效或未登录';

    const INVALID_DATA = '请正确选择日期范围';

    const VALID_ACTION = '操作成功';

    const INVALID_ACTION = '未知操作';

    const VERIFY_SUCCESS = '验证成功';

    const ACTION_SUCCESS = '获取成功';

    const PASSWORD_REQUIRE = '旧密码不能为空';

    const NEW_PASSWORD_REQUIRE = '新密码不能为空';

    const RE_PASSWORD_REQUIRE = '确认密码不能为空';

    const RE_PASSWORD_CONFIRM = '新密码与确认密码不相同';

    const PASSWORD_CONFIRM = '旧密码输入错误';

    const NEW_PASSWORD_ONLY_6_NUM = '密码只能为 6 位数字';

    const NEW_PASSWORD_INVALID = '密码只能是 6-20 位字符';

    const BANK_INVALID = '银行名称格式不正确';

    const CARD_NO_INVALID = '银行卡号格式不正确';

    const ADDRESS_INVALID = '开户地址格式不正确';

    const CARD_IS_SET = '您已经添加过银行账户信息';

    const WITHDRAW_LIMIT_TIME = '为了方便及时给您出款，30 秒之内请勿多次提交提款申请';

    const WITHDRAW_INVALID_MONEY = '请输入有效提款金额';

    const WITHDRAW_LIMIT_MONEY = '提款金额不能小于 %.2f 元';

    const WITHDRAW_EXCEED_MONEY = '账户余额不足';

    const WITHDRAW_INVALID_TIME = '允许申请提款的时间为 %s 至 %s';

    const WITHDRAW_INVALID_PASSWORD = '提款密码不正确，请重新输入';

    const WITHDRAW_IN_PROGRESS = '您有未处理的提款订单，请等待完成';

    const WITHDRAW_MAX_COUNT = '今日提款次数已经用完，请明日再申请提款';

    const CASINO_DEFAULT_API = '../cj/live/live_money.php';

    const INVALID_CASINO = '所选游戏平台已关闭或无效';

    const CASINO_CAN_NOT_SAME_PLATFORM = '不能相同的转出和转入平台';

    const CASINO_INVALID_TRANSFER_MONEY = '无效的转换金额';

    const CASINO_ONLY_INTEGER_MONEY = '转换金额只能整数';

    const CASINO_TRANSFER_SUCCESS = '额度转换成功';

    const CASINO_DENY_TRANSFER = '您暂时不能进行额度转换';

    const DEPOSIT_TRANSFER_COMMON_INVALID = '发生错误，请刷新页面重试';

    const DEPOSIT_TRANSFER_INVALID_TIME = '请选择有效转账时间';

    const DEPOSIT_TRANSFER_INVALID_MONEY = '请输入有效转账金额';

    const DEPOSIT_TRANSFER_LIMIT_MONEY = '转账金额不能小于 %.2f 元';

    const DEPOSIT_TRANSFER_INVALID_ACTION = '请选择或填写转账方式';

    const DEPOSIT_TRANSFER_WAITING_CONFIRM = '您有未处理的存款订单，请等待完成';

    const DEPOSIT_TRANSFER_INVALID_USERNAME = '请填写转账人姓名或昵称';

    const DEPOSIT_INVALID_CODE = '支付方式已关闭，请刷新页面重试';
}