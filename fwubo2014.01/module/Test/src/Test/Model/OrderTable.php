<?php
namespace Test\Model;
/**
 *�̳Ƕ�����
 */
class OrderTable
{
	private $order_id;		//����ID
	private $order_sn;		//������
	private $type;			//��������
	private $extension;		//������չ��Ϣ
	private $seller_id;		//�̼�ID
	private $seller_name;		//�̼���
	private $buyer_id;		//������ID
	private $buyer_name;		//��������
	private $buyer_email;		//������EMAIL
	private $status;			//����״̬
	private $add_time;		//�µ�ʱ��
	private $payment_id;		//֧����ʽ
	private $payment_name;	//֧����
	private $payment_code;		//֧������
	private $out_trade_sn;		//�ⲿ֧����
	private $pay_time;		//֧��ʱ��
	private $pay_message;		//֧����Ϣ
	private $ship_time;		//����ʱ��
	private $invoice_no;	//��Ʊ��
	private $finished_time;	//���ʱ��
	private $goods_amount;	//�ϼ��ܽ��
	private $discount;	//�ۿۼ�
	private $order_amount;	//�����ۿۼ�
	private $evaluation_status;	//����״̬
	private $evaluation_time;	//����ʱ��
	private $anonymous;	//�Ƿ�����
	private $postscript;	//������Ϣ
}