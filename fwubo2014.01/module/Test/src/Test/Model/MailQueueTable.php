<?php
namespace Test\Model;
/**
 *�ʼ����б�
 */
class MailQueueTable
{
	private $queue_id;		//�ʼ�����ID
	private $mail_to;		//���ܷ���ַ
	private $mail_encoding;	//�ʼ������ʽ
	private $mail_subject;	//�ʼ�����
	private $mail_body;		//�ʼ�����
	private $priority;		//���ȼ�
	private $err_num;		//������
	private $add_time;		//����ʱ��
	private $lock_expiry;   //����
}