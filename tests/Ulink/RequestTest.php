<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 6/24/11
 * Time: 12:17 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Ulink;


class RequestTests extends \PHPUnit_Framework_TestCase {

    public function testAuthRequest() {
        $request = new AuthRequest();
        $request->setTimestamp(123);
        $request->setClientTransactionId(456);
        $this->assertEquals("{\"type\":\"auth\",\"timestamp\":123,\"id\":456,\"data\":{}}", $request->toJson());
    }

    public function testPayRequest() {
        $request = new PaymentRequest();
        $request->setAmount(new Money('23.50'));
        $request->setCurrency("EUR");
        $request->setTimestamp(123);
        $request->setClientTransactionId(456);

        $this->assertEquals("{\"type\":\"pay\",\"timestamp\":123,\"id\":456,\"data\":{" .
                    "\"amount\":\"23.50\",\"currency\":\"EUR\"" .
                "}}", $request->toJson());
    }

    /**
     * @group pay-req-order
     */
    public function testPayRequestWithOrder() {

        $order = $this->getMock('Ulink\Order');
        $order->expects($this->any())->method('getJsonData')->will($this->returnValue('foo'));

        $request = new PaymentRequest();
        $request->setAmount(new Money('23.50'));
        $request->setCurrency("EUR");
        $request->setTimestamp(123);
        $request->setOrder($order);

        $this->assertEquals("{\"type\":\"pay\",\"timestamp\":123,\"data\":{" .
                    "\"amount\":\"23.50\",\"currency\":\"EUR\"" .
                ",\"order\":\"foo\"}}", $request->toJson());
    }

    public function orderListToJson() {

        $item1 = $this->getMock('Ulink\OrderItem');
        $item1->expects($this->any())->method('getJsonData')->will($this->returnValue('foo'));
        $item2 = $this->getMock('Ulink\OrderItem');
        $item2->expects($this->any())->method('getJsonData')->will($this->returnValue('bar'));

        $items = array($item1,$item2);

        $order = new Order();
        $order->setItems($items);

        $this->assertEquals(array('foo','bar'), $order->getJsonData());
    }

    public function orderItemToJson() {
        $item = new OrderItem("foo", "Tom's \"big\" dog", new Money('35.90'), 2);

        assertEquals(array('name' => "foo", 'descr' => "Tom's \"big\" dog" , 'qty' => 2, 'price' => 35.90), $item->getJsonData());
    }
}
