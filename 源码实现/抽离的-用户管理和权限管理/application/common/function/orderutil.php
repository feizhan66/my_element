<?php


/**
 * 计算真实订单状态
 *
 * @param $order_status     // 订单状态（1、未结单 2、已结单）
 *                            【虚拟类型订单：1、不存在可使用、退款中、改签中的虚拟商品时，切换为已结单；2、支付超时导致取消订单，3、待支付状态时，手动取消订单】
 *                            【实物类型订单：待确认】
 * @param $pay_status       // 支付状态（0、未支付 1、部分支付 2、全额支付 3、超额支付）
 * @param $delivery_status  // 物流状态（0、未发货 1、部分发货 2、全部发货 3、确认收货）
 *                            【虚拟类型订单：默认为2-全部发货；不存在可使用、退款中、改签中的虚拟商品时，切换为确认收货】
 *                            【实物类型订单：默认为0-未发货；其他待确认】
 *
 * @return int              // 返回真实订单状态
 *                              0、未知状态
 *                              1、待支付(包含部分支付)
 *                              2、待发货(包含部分发货)
 *                              3、待确认/待使用(包含部分待确认/待使用)【备注：如果是虚拟商品，状态为待使用，如果为实物商品，状态为待确认】
 *                              4、已完成
 *                              5、已取消
 *                              6、退款中
 *
 * 备注：优先显示物流状态信息，再显示退款信息
 *
 */
function order_true_status($order_status,$pay_status,$delivery_status)
{
    // 第一步：判断是否已结单
    if ($order_status == 1)
    {// 未结单
        // 第二步：判断支付状态
        if ($pay_status == 0 || $pay_status == 1)
        {// 未支付|部分支付
            return 1;   // 返回：待支付(包含部分支付)
        }
        else if ($pay_status == 2 || $pay_status == 3)
        {// 全额支付|超额支付
            // 第三步：判断物流状态
            if ($delivery_status == 0 || $delivery_status == 1)
            {// 未发货|部分发货
                return 2;   // 返回：待发货(包含部分发货)；
            }
            else if ($delivery_status == 2)
            {// 全部发货
                return 3;   // 返回：待确认/待使用(包含部分待确认/待使用)；
            }
            else if ($delivery_status == 3)
            {// 确认收货
                return 4;   // 返回：已完成
            }
            else
            {// 未知状态
                return 1;   // 返回：未知状态
            }
        }
        else
        {// 未知状态
            return 1;   // 返回：未知状态
        }
    }
    else if ($order_status == 2)
    {// 已结单
        if ($pay_status == 0)
        {// 未支付
            return 5;   // 返回：已取消
        }
        else if ($pay_status == 1)
        {// 部分支付(异常情况)
            return 6;   // 返回：退款中
        }
        else if ($pay_status == 3)
        {// 超额支付(异常情况)
            return 6;   // 返回：退款中
        }
        return 4;   // 返回：已完成
    }
    else
    {// 未知状态
        return 1;   // 返回：未知状态
    }
}
/**
 * 判断订单是否可支付
 * @param $order_true_status    订单真实状态
 * @return int                  返回可支付状态：0-不可支付，1-可支付
 */
function order_can_pay($order_true_status)
{
    if ($order_true_status==1)
    {
        return 1;   // 可支付
    }
    else
    {
        return 0;   // 可不支付
    }
}
/**
 * 判断订单是否可取消
 * @param $order_true_status    订单真实状态
 * @return int                  返回可取消状态：0-不可取消，1-可取消
 */
function order_can_cancel($order_true_status)
{
    if ($order_true_status==1)
    {
        return 1;   // 可取消
    }
    else
    {
        return 0;   // 可不取消
    }
}
/**
 * 判断订单是否可评论
 * @param $order_true_status    订单真实状态
 * @return int                  返回可评论状态：0-不可评论，1-可评论
 */
function order_can_comment($order_true_status, $comment_tid)
{
    if ($order_true_status==4 && empty($comment_tid))
    {
        return 1;   // 可评论
    }
    else
    {
        return 0;   // 可不评论
    }
}
/**
 * 判断是否已结单
 *
 * @param $order_ticket_item_true_status_array  // 订单商品（票）真实状态 数组集合（如：[1,2,3,4]）
 * @return int                                  // 返回是否已结单
 *                                                  0-未结单
 *                                                  1-已结单
 *
 */
function order_ticket_is_order_complete($order_ticket_item_true_status_array)
{
    foreach ($order_ticket_item_true_status_array as $key=>$value)
    {
        if ($value==1 || $value==5 || $value==7)
        {// 判断是否有 可使用、退款中、改签中 的虚拟商品
            return 0;   // 返回：未结单
        }
    }
    return 1;   // 返回：已结单
}
/**
 * 判断是否确认收货
 *
 * @param $order_ticket_item_true_status_array  // 订单商品（票）真实状态 数组集合（如：[1,2,3,4]）
 * @return int                                  // 返回是否确认收货
 *                                                  0-未确认收货
 *                                                  1-已确认收货
 *
 */
function order_ticket_is_delivery_complete($order_ticket_item_true_status_array)
{
    foreach ($order_ticket_item_true_status_array as $key=>$value)
    {
        if ($value==1 || $value==5 || $value==7)
        {// 判断是否有 可使用、退款中、改签中 的虚拟商品
            return 0;   // 返回：未确认收货
        }
    }
    return 1;   // 返回：已确认收货
}
/**
 * 判断是否可退票
 *
 * @param $order_ticket_items  // 订单商品（票）数组集合
 * @return int                 // 返回是否可退票
 *                                0-不可退票
 *                                1-可退票
 *
 */
function order_ticket_can_refund($order_ticket_items)
{
    foreach ($order_ticket_items as $key=>$value)
    {// 检查是否存在可退票商品（票）
        if ($value['can_refund']==1)
        {
            return 1;   // 返回：可退票
        }
    }
    return 0;   // 返回：不可退票
}
/**
 * 判断是否可改签
 *
 * @param $order_ticket_items  // 订单商品（票）数组集合
 * @return int                 // 返回是否可改签
 *                                0-不可改签
 *                                1-可改签
 *
 */
function order_ticket_can_change($order_ticket_items)
{
    foreach ($order_ticket_items as $key=>$value)
    {// 检查是否存在可改签商品（票）
        if ($value['can_change']==1)
        {
            return 1;   // 返回：可改签
        }
    }
    return 0;   // 返回：不可改签
}



/**
 * 计算订单商品（票）真实状态
 *
 * @param $order_pay_status     // 订单支付状态（0-未支付 1-部分支付 2-全额支付 3-超额支付）
 * @param $refund_status        // 退款状态（0-无退款 1-退款中 2-已退款）【退款逻辑说明：当处于退款中时，如退款成功，状态改为已退款，如退款失败，状态改为无退款。退款成功与失败在退款记录表里面体现】
 * @param $change_status        // 改签状态（0-无改签 1-改签中 2-已改签 3-改签后）【改签逻辑说明：当处于改签中时，如改签成功，状态改为已改签，如改签失败，状态改为无改签。改签成功与失败在改签记录表里面体现】
 * @param $consume_status       // 使用状态（0-未使用 1-已使用 2-已过期）
 * @return int                  // 返回订单商品（票）真实状态
 *                              1、可使用
 *                              2、已使用
 *                              3、已过期
 *                              4、不可用
 *                              5、退款中
 *                              6、已退款
 *                              7、改签中
 *                              8、已改签
 *
 * 备注：只有订单商品（票）真实状态为1时，才能使用该商品（票）进行票务验证使用
 *
 */
function order_ticket_item_true_status($order_pay_status,$refund_status,$change_status,$consume_status)
{
    if ($order_pay_status == 0 || $order_pay_status == 1)
    {// 未支付|部分支付
        return 4;   // 不可用
    }
    else if ($order_pay_status == 2 || $order_pay_status == 3)
    {// 全额支付|超额支付
        // 第一步：判断使用状态
        if ($consume_status == 0)
        {// 未使用
            // 第二步：判断退款状态
            if ($refund_status == 0)
            {// 无退款
                // 第三步：判断改签状态
                if ($change_status == 0)
                {// 无改签
                    return 1;   // 返回：可使用
                }
                else if ($change_status == 1)
                {// 改签中
                    return 7;   // 返回：改签中
                }
                else if ($change_status == 2)
                {// 已改签
                    return 8;   // 返回：已改签
                }
                else if ($change_status == 3)
                {// 改签后
                    return 1;   // 返回：可使用
                }
                else
                {// 未知状态
                    return 4;   // 返回：不可用
                }
            }
            else if ($refund_status == 1)
            {// 退款中
                return 5;   // 返回：退款中
            }
            else if ($refund_status == 2)
            {// 已退款
                return 6;   // 返回：已退款
            }
            else
            {// 未知状态
                return 4;   // 返回：不可用
            }
        }
        else if ($consume_status == 1)
        {// 已使用
            return 2;   // 返回：已使用
        }
        else if ($consume_status == 2)
        {// 已过期
            return 3;   // 返回：已过期
        }
        else
        {// 未知状态
            return 4;   // 返回：不可用
        }
    }
    else
    {// 未知状态
        return 4;   // 返回：不可用
    }
}
/**
 * 获取订单正式状态描述
 * @param $order_ticket_item_true_status
 * @return string
 */
function get_order_ticket_item_true_status_text($order_ticket_item_true_status)
{
    $status = array(1=>'可使用', 2=>'已使用', 3=>'已过期', 4=>'不可用', 5=>'退款中', 6=>'已退款', 7=>'改签中', 8=>'已改签');
    return $status[$order_ticket_item_true_status];
}
/**
 * 计算订单商品（票）是否可退款
 *
 * @param $can_refund                       是否支持退款标识
 * @param $change_status                    订单商品（票）改签状态
 * @param $order_ticket_item_true_status    订单商品（票）真实状态
 * @return int                              返回订单商品（票）是否可退款
 *                                          1、可退款
 *                                          2、不可退款
 */
function order_ticket_item_can_refund($can_refund, $change_status, $order_ticket_item_true_status)
{
    // 只有支持退款订单商品（票）
    // 并且 订单商品（票）改签状态为0-未改签时，才能进行退款操作
    // 并且 订单商品（票）真实状态为1-可使用时，才能进行退款操作
    if ($can_refund==1 && $change_status==0 && $order_ticket_item_true_status==1)
    {
        return 1;   // 返回：可退款
    }
    else
    {
        return 0;   // 返回：不可退款
    }
}
/**
 * 计算订单商品（票）是否可改签
 *
 * @param $can_change                       是否支持改签标识
 * @param $change_status                    订单商品（票）改签状态
 * @param $order_ticket_item_true_status    订单商品（票）真实状态
 * @return int                              返回订单商品（票）是否可改签
 *                                          1、可改签
 *                                          2、不可改签
 */
function order_ticket_item_can_change($can_change, $change_status, $order_ticket_item_true_status)
{
    // 只有支持改签订单商品（票）
    // 并且 订单商品（票）改签状态为0-未改签时，才能进行退款操作
    // 并且 订单商品（票）真实状态为1-可使用时，才能进行退款操作
    if ($can_change==1 && $change_status==0 && $order_ticket_item_true_status==1)
    {
        return 1;   // 返回：可改签
    }
    else
    {
        return 0;   // 返回：不可改签
    }
}
