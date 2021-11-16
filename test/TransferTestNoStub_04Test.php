<?php
use PHPUnit\Framework\TestCase;

include __DIR__."/../src/transfer/transfer.php";
use Operation\transfer;



class TransferTestNoStub_04Test extends TestCase
{
    /**
	* add DataProvider
	*
	* @dataProvider dataProvider
	*
	*/
    public function test_WB($srcAccNo, $srcAccBalance, $targetNumber, $targetAmount, $expected)
	{
        $srcAccName = 'Test Test';
        $transfer = new transfer($srcAccNo, $srcAccName);
        $response = $transfer->doTransfer($targetNumber, $targetAmount);
        
        $this->assertSame($expected, $response['message']);
	}

    public function dataProvider() {
		return [
            ['3455677565', 500000, 'abcdefghij', 100, 'หมายเลขบัญชีต้องเป็นตัวเลขเท่านั้น'], // WB_01
            ['3455677565', 500000, '0123456789', 'abcd', 'จำนวนเงินต้องเป็นตัวเลขเท่านั้น'], // WB_02
            ['3455677565', 500000, '01234567890', 100, 'หมายเลขบัญชีต้องมีจำนวน 10 หลัก'], // WB_03
            ['3455677565', 10000000, '0123456789', 10000000, 'ยอดการโอนต้องไม่มากกว่า 9,999,999 บาท'], // WB_04
            ['3455677565', 10000000, '3455677565', 100, 'ไม่สามารถโอนไปบัญชีตัวเองได้'], // WB_05
            ['3455677565', 500000, '0123456789', 0, 'ยอดการโอนต้องมากกว่า 0 บาท'], // WB_06
            ['3455677565', 100, '0123456789', 9999999, 'คุณมียอดเงินในบัญชีไม่เพียงพอ'], // WB_08
            ['3455677565', 100, '9999999999', 100, ''], // WB_09
            ['7234153321', 600000, '345567756a', 100, 'หมายเลขบัญชีต้องเป็นตัวเลขเท่านั้น'], // BB_01
            ['7234153321', 600000, '123456789', 100, 'หมายเลขบัญชีต้องมีจำนวน 10 หลัก'], // BB_02
            ['7234153321', 600000, '1234567890', '100a', 'จำนวนเงินต้องเป็นตัวเลขเท่านั้น'], // BB_04
            ['7777777777', 600, '0123456789', 9999999, 'คุณมียอดเงินในบัญชีไม่เพียงพอ'], // BB_05
            ['777777777a', 600, '01234567890', 9999999, 'หมายเลขบัญชีต้องเป็นตัวเลขเท่านั้น'], // BB_06
            ['3455677565a', 200, '1234567890', 100, 'หมายเลขบัญชีต้องเป็นตัวเลขเท่านั้น'], // BB_07
            ['9999999999', 200, '1234567890', 2000000, 'คุณมียอดเงินในบัญชีไม่เพียงพอ'], // BB_08
            ['9999999991', '200a', '1234567890', 100, 'คุณมียอดเงินในบัญชีไม่เพียงพอ'], // BB_09
            ['9999999990', 100, '1234567890', 100, 'คุณมียอดเงินในบัญชีไม่เพียงพอ'], // BB_10
            ['1234567890', 100, '7234153321', 0, 'ยอดการโอนต้องมากกว่า 0 บาท'], // BB_11
        ];
	}
    
    /**
	* add DataProvider
	*
	* @dataProvider dataProvider2
	*
	*/
    public function test_exception($srcAccNo, $srcAccBalance, $targetNumber, $targetAmount)
    {
        $this->expectException(Exception::class);

        $srcAccName = 'Test Test';
        $tran = new transfer($srcAccNo, $srcAccName);

        $tran->doTransfer($targetNumber, $targetAmount);
    }

    public function dataProvider2() {
		return [
            ['3455677565', 10000000, '0000000000', 100], // WB_07
            ['7234153321', 500000, '0000000000', 100], // BB_03
        ];
	}

    public function test_WB_010()
    {  
        $srcAccNo = '3455677565';
        $srcAccName = 'Metavy';
        $transfer = new TestTransferStubAll($srcAccNo,$srcAccName);
        $targetNumber = '1234567890';
        $targetAmount = 100;
        $transferResult = $transfer->doTransfer($targetNumber,$targetAmount);
        $this->assertEquals(false, $transferResult['isError']);
        $this->assertEquals(999900, $transferResult['accBalance']);
        $this->assertEquals('', $transferResult['message']);
    }

    public function test_BB_012()
    {  
        $srcAccNo = '3455677565';
        $srcAccName = 'Metavy';
        $transfer = new TestTransferStubAll($srcAccNo,$srcAccName);
        $targetNumber = '1234567890';
        $targetAmount = 100;
        $transferResult = $transfer->doTransfer($targetNumber,$targetAmount);
        $this->assertEquals(false, $transferResult['isError']);
        $this->assertEquals(999900, $transferResult['accBalance']);
        $this->assertEquals('', $transferResult['message']);
    }
}