<?php
/**
1）merchant_private_key，商户私钥;merchant_public_key,商户公钥；商户需要按照《密钥对获取工具说明》操作并获取商户私钥，商户公钥。
2）demo提供的merchant_private_key、merchant_public_key是测试商户号1111110166的商户私钥和商户公钥，请商家自行获取并且替换；
3）使用商户私钥加密时需要调用到openssl_sign函数,需要在php_ini文件里打开php_openssl插件
4）php的商户私钥在格式上要求换行，如下所示；
*/
		$merchant_private_key='-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJB7DFWoipYYfB3S
euSrcKQfbQIKd7dHKk9W9IdlsIgAFeL09Z35pC48mxRhtxwbqA8Ert2E1AtyfXDa
jd9zLJwc2dgXc5P50d+3TauoymHoYs7gTSrwal4A95F1cswWqU1DIsuatPs2b8wO
dg/3dDqBLWtoiCe04TY8epGj2AMDAgMBAAECgYEAjFcpzQ6wx0kzTpiEDRjGinWI
IkJetSWoYHbbgaVySziiCdndtzylkNAH501fWys2HJh07vG2MwRb+sIgqxsqCWBn
VTlKMcr70bniEsKQrUqZ8dI9naSbhZBbmaoourm94zVy+3tYyUmnogfl5MQZSSxJ
3FKTlVwYeC0L81BPcEECQQDs8dGIC5KCfs2ZcuVlsGY/uvV0VktUadN+uE2l53Wy
1J19F56JBkC/2PI6QOkqyukaTAvX6bNukDR3dGHzJyPjAkEAnBmYYO3QeOws+hfE
1PocG0kVKtXpCepC+/JoRBNayZpEfh6i0bNXqLZvusCWfI/6Ve8WgopSvL12tOTK
eU8OYQJASMDbgHVlMBJ1WMeRrk6iprDmSylwCeRQn1lB5k4Ssq1cChvlftdfrEiV
39MshQo21u9At7Q3dxxqL7+Zj8qV1wJAdnY6HHz9c3cQHu9A0bvI7rAEn1BcnMip
8tegZuElSc+H4QpQ18E5afChU+FpkrgU63gY5hIg/djuqBLk0TC8oQJAYI5yPg5n
cyhqVR9IardzSSoQjXxoPq0Iuciaa5132O2k48Wo7Mdv9IwQW7rlKv5r4lL3ppdK
YtuE+lVUyDTXIA==
-----END PRIVATE KEY-----';

	//merchant_public_key,商户公钥，按照说明文档上传此密钥到智汇付商家后台，位置为"支付设置"->"公钥管理"->"设置商户公钥"，代码中不使用到此变量
	//demo提供的merchant_public_key已经上传到测试商家号后台
	$merchant_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCQewxVqIqWGHwd0nrkq3CkH20C
Cne3RypPVvSHZbCIABXi9PWd+aQuPJsUYbccG6gPBK7dhNQLcn1w2o3fcyycHNnY
F3OT+dHft02rqMph6GLO4E0q8GpeAPeRdXLMFqlNQyLLmrT7Nm/MDnYP93Q6gS1r
aIgntOE2PHqRo9gDAwIDAQAB
-----END PUBLIC KEY-----';
	
/**
1)dinpay_public_key，智汇付公钥，每个商家对应一个固定的智付公钥（不是使用工具生成的密钥merchant_public_key，不要混淆），
即为智付商家后台"公钥管理"->"智付公钥"里的绿色字符串内容,复制出来之后调成4行（换行位置任意，前面三行对齐），
并加上注释"-----BEGIN PUBLIC KEY-----"和"-----END PUBLIC KEY-----"
2)demo提供的dinpay_public_key是测试商户号1111110166的智付公钥，请自行复制对应商户号的智付公钥进行调整和替换。
3）使用智付公钥验证时需要调用openssl_verify函数进行验证,需要在php_ini文件里打开php_openssl插件
*/
			$dinpay_public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDk56XzP72e9W832mJ+tqvlWW/W
oB+BAUMiTAYMWQQ6PEqyyqegEIyfhvK37X+uPkxBUlh9sc9NgYsuI7Vo/0qMGviN
EMcWYJJnyy1b+cZ7jl75ISdAuImnkDPUSkxaEn4cYNEIY+tGD3o6+Bqc/Z2xWPzG
JD61NMnstRMrHS9TlQIDAQAB
-----END PUBLIC KEY-----'; 


	



?>