<?php
/**
1）merchant_private_key，商户私钥;merchant_public_key,商户公钥；商户需要按照《密钥对获取工具说明》操作并获取商户私钥，商户公钥。
2）demo提供的merchant_private_key、merchant_public_key是测试商户号988000000008的商户私钥和商户公钥，请商家自行获取并且替换；
3）使用商户私钥加密时需要调用到openssl_sign函数,需要在php_ini文件里打开php_openssl插件
4）php的商户私钥在格式上要求换行，如下所示；
*/
		$merchant_private_key='-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAODizRp86dcOUxJX
N7zJvNOFQFBvYjtAZUzjz3A2cKZl3dEp3vWww4VoLNMnhVzh+O/aZd/FH1RNvta4
jkeelzOKYd+m9h9ERTTSEMzA6R4FORy34TjQOj60E2IJ7wfFSltE1LIOaQNWUmZ4
AHwXH0b4pasID7RGsc5GJNtzySKPAgMBAAECgYAnIO9E+5UIWTK1Dz3geE2FlDrT
g/3Yh2TY0w6F3MMPAMxul1V29FGgxbZ+6vJ2bc8NlLeDDt5bocdhvuzqozp1Zso0
4d/iKuCBwx7MTZcB4N2DNHuYqOd3Y5vu2i/LipR9gMIdKkp1+ADFz7jzCteT4IUZ
iYp0XL3lriRX3Zo62QJBAPXDLtGN4nqVpUf7OUISWJz+HaoBGckcQ/G6ENXE9BxJ
Wpw7GTspHIfpfRJnMj6tjsX4x4r6NzuahGPAO6/1wsMCQQDqQP2oEB6NgQeLVDPq
hpdAmNYx494ALVnyS5y5QduSMZr/lK6dgxyb7M+c5inQTaX3VwPkcesRSAqBp4xN
Q4xFAkAiLWSja9HlLk5v9jX+RELigkxpygFmAHJKeY/BysQP8vuQ4n8dxRfcptHn
70YDhWtniLNnVmi79z8WCDPEwq61AkBhsPbX1tkXBB9kUJpSDQ0Y6GQzbCcSBdfD
/xp9++QY5M0SFyx3Dc2pjSnL8gSwFSHIs6Yw5/0zOMsA5SHSuv/NAkEA7NvXKw+e
ECEzqsyTfTpOjLjrjGzddwfbd4zcMjp0evHxCu3DdgNtzu0GG0UhhpN1Pf7sbG+o
QUN90kBmgguMlQ==
-----END PRIVATE KEY-----';

	//merchant_public_key,商户公钥，按照说明文档上传此密钥到财运快汇商家后台，位置为"支付设置"->"公钥管理"->"设置商户公钥"，代码中不使用到此变量
	//demo提供的merchant_public_key已经上传到测试商家号后台
	$merchant_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDg4s0afOnXDlMSVze8ybzThUBQ
b2I7QGVM489wNnCmZd3RKd71sMOFaCzTJ4Vc4fjv2mXfxR9UTb7WuI5HnpczimHf
pvYfREU00hDMwOkeBTkct+E40Do+tBNiCe8HxUpbRNSyDmkDVlJmeAB8Fx9G+KWr
CA+0RrHORiTbc8kijwIDAQAB
-----END PUBLIC KEY-----';
	
/**
1)debaozhifu_public_key，财运快汇公钥，每个商家对应一个固定的财运快汇公钥（不是使用工具生成的密钥merchant_public_key，不要混淆），
即为财运快汇商家后台"公钥管理"->"财运快汇公钥"里的绿色字符串内容,复制出来之后调成4行（换行位置任意，前面三行对齐），
并加上注释"-----BEGIN PUBLIC KEY-----"和"-----END PUBLIC KEY-----"
2)demo提供的debaozhifu_public_key是测试商户号988000000008的智付公钥，请自行复制对应商户号的智付公钥进行调整和替换。
3）使用财运快汇公钥验证时需要调用openssl_verify函数进行验证,需要在php_ini文件里打开php_openssl插件
*/
	$debaozhifu_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCNXMIo181TsQxQRlWPjvjvKgEK
TIZnxlW5kcT9uc9g88VxaVhI00QanAfliLI+yHsREpR8+AgkZErILrljX8AEWzmP
/7sBNCIV7HEMe8N3lt6WKDuC4Ihsh8P7lU3rZWjbPG5lLuvypNTCRwMy5SebQHJG
4rN270MMPokmzDRibQIDAQAB
-----END PUBLIC KEY-----';





	



?>