## 基本 API 描述
> 关于文章中出现的 SecretId、SecretKey、Bucket 等名称的含义和获取方式请参考：[COS 术语信息](https://cloud.tencent.com/document/product/436/7751)

### 获取Bucket列表
#### 方法原型
```php
public Guzzle\Service\Resource\Model listBucket(array $args = array())
```

#### 示例

```php
//获取bucket列表
$result = $cosClient->listBuckets();
```

### 创建Bucket

#### 方法原型

```php
// 创建桶
public Guzzle\Service\Resource\Model createBucket(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Acl      |     string     |  无    | 否           |         ACL权限控制         |

#### 示例

```php
//创建桶
//bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
$result = $cosClient->createBucket(array('Bucket' => 'testbucket-125000000'));
```

### 删除Bucket

#### 方法原型

```php
// 删除桶
public Guzzle\Service\Resource\Model deleteBucket(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |

#### 示例

```php
//删除桶
//bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
$result = $cosClient->deleteBucket(array('Bucket' => 'testbucket-125000000'));
```

### 简单文件上传

#### 方法原型

```php
public Guzzle\Service\Resource\Model putObject(array $args = array())
```

#### 参数说明

$args是包含以下字段的关联数组：

| 参数名称   | 描述   |类型 | 是否必填字段 | 
| -------------- | -------------- |---------- | ----------- |
 |  Bucket  |  Bucket 名称，由数字和小写字母以及中划线 "-" 构成 | string |   是 |
 |  Body  | 上传文件的内容，可以为文件流或字节流 |  file/string |  是 |
 |  Key  | 上传文件的路径名，默认从 Bucket 开始 | string |  是 | 
 |  ACL  | 设置文件的 ACL，如 'private，public-read'，'public-read-write' | string |   否 | 
 |  GrantFullControl  |赋予指定账户对文件的读写权限 |  string |  否 | 
 |  GrantRead  |  赋予指定账户对文件读权限 | string |  否 |
 |  GrantWrite  |  赋予指定账户对文件的写权限 | string |  否 |
 |  StorageClass  |  设置文件的存储类型，STANDARD,STANDARD_IA，NEARLINE，默认值：STANDARD | String |   否 |
 |  Expires  | 设置 Content-Expires | string|  否 | 
 |  CacheControl  |  缓存策略，设置 Cache-Control | string |   否 |
 |  ContentType  | 内容类型，设置 Content-Type |string |   否 |  
 |  ContentDisposition  |  文件名称，设置 Content-Disposition | string |   否 |
 |  ContentEncoding  |  编码格式，设置 Content-Encoding | string |   否 |
 |  ContentLanguage  |  语言类型，设置 Content-Language | string |   否 |
 |  ContentLength  | 设置传输长度 | string |   否 | 
 |  ContentMD5  | 设置上传文件的 MD5 值用于校验 | string |   否 | 
 |  Metadata | 用户自定义的文件元信息 | array |   否 |
#### 示例

```php
// 从内存中上传
#putObject
try {
    $result = $cosClient->putObject(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
        'Key' => 'string',
        'Body' => 'Hello World!',
        'CacheControl' => 'string',
        'ContentDisposition' => 'string',
        'ContentEncoding' => 'string',
        'ContentLanguage' => 'string',
//        'ContentLength' => integer,
//        'ContentType' => 'string',
//        'Expires' => 'mixed type: string (date format)|int (unix timestamp)|\DateTime',
//        'GrantFullControl' => 'string',
//        'GrantRead' => 'string',
//        'GrantWrite' => 'string',
//        'Metadata' => array(
//            'string' => 'string',
//        ),
//        'StorageClass' => 'string',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
// 上传本地文件
#putObject
try {
    $result = $cosClient->putObject(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
        'Key' => 'string',
        'Body' => fopen('./hello.txt', 'rb'),
        'CacheControl' => 'string',
        'ContentDisposition' => 'string',
        'ContentEncoding' => 'string',
        'ContentLanguage' => 'string',
//        'ContentLength' => integer,
//        'ContentType' => 'string',
//        'Expires' => 'mixed type: string (date format)|int (unix timestamp)|\DateTime',
//        'GrantFullControl' => 'string',
//        'GrantRead' => 'string',
//        'GrantWrite' => 'string',
//        'Metadata' => array(
//            'string' => 'string',
//        ),
//        'StorageClass' => 'string',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```



### 分块文件上传

分块文件上传是通过将文件拆分成多个小块进行上传，多个小块可以并发上传, 最大支持40TB。

分块文件上传的步骤为:

1. 初始化分块上传，获取uploadid。(createMultipartUpload)
2. 分块数据上传(可并发).  (uploadPart)
3. 完成分块上传。 (completeMultipartUpload)

另外还包含获取已上传分块(listParts), 终止分块上传(abortMultipartUpload)。

#### 方法原型

```php
// 初始化分块上传
public Guzzle\Service\Resource\Model createMultipartUpload(array $args = array());

// 上传数据分块
public Guzzle\Service\Resource\Model uploadPart(array $args = array());
            
// 完成分块上传
public Guzzle\Service\Resource\Model completeMultipartUpload(array $args = array());

// 罗列已上传分块
public Guzzle\Service\Resource\Model listParts(array $args = array());

// 终止分块上传
public Guzzle\Service\Resource\Model abortMultipartUpload(array $args = array());
```
### 上传文件
#### 示例
```php
//上传文件
try {
    $result = $cosClient->upload(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        $bucket='testbucket-1252448703',
        $key = '111.txt',
        $body = fopen('./hello.txt', 'rb'),
        $options = array(
            "ACL"=>'private',
            'CacheControl' => 'private'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```
单文件小于5M时，使用单文件上传
反之使用分片上传

### 下载文件

将文件下载到本地或者下载到内存中.

#### 方法原型

```php
// 下载文件
public Guzzle\Service\Resource\Model getObject(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Key      |     string     |  无    | 是           |         对象名称         |
| SaveAs   |     string     |  无    | 否           | 保存到本地的本地文件路径                 |
| VersionId      |     string     |  无    | 否           |         对象版本号        |


#### 示例

```php
// 下载文件到内存
$result = $cosClient->getObject(array(
    //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
    'Bucket' => 'testbucket-125000000',
    'Key' => 'hello.txt'));
echo($result['Body'])

// 下载文件到本地
$result = $cosClient->getObject(array(
    //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
    'Bucket' => 'testbucket-125000000',
    'Key' => 'hello.txt',
    'SaveAs' => './hello.txt'));
```


### 删除文件

删除COS上的对象.

#### 方法原型

```php
// 删除文件
public Guzzle\Service\Resource\Model deleteObject(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: | :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Key      |     string     |  无    | 是           |         对象名称         |
| VersionId      |     string     |  无    | 否           |         对象版本号        |

#### 示例

```php
// 删除COS对象
$result = $cosClient->deleteObject(array(
    //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
    'Bucket' => 'testbucket-125000000',
    'Key' => 'hello.txt'));
```



### 获取对象属性

查询获取COS上的对象属性

#### 方法原型

```php
// 获取文件属性
public Guzzle\Service\Resource\Model headObject(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: | :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Key      |     string     |  无    | 是           |         对象名称         |
| VersionId      |     string     |  无    | 否           |         对象版本号        |



#### 示例

```php
// 获取COS文件属性
 //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
$result $cosClient->headObject(array('Bucket' => 'testbucket-125000000', 'Key' => 'hello.txt'));
```


### 获取文件列表

查询获取COS上的文件列表

#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model listObjects(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: | :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Delimiter      |     string     |  无    | 否          |         分隔符         |
| Marker      |     string     |  无    | 否          |         标记        |
| MaxKeys      |     int     |  无    | 否          |         最大对象个数         |
| Prefix      |     string     |  无    | 否           |         前缀         |

#### 示例

```php
// 获取bucket下成员
//bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
$result = $cosClient->listObjects(array('Bucket' => 'testbucket-125000000'));
```
### putBucketACL

#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model putBucketACL(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| ACL      |     string     |  无    | 否           |         ACL权限控制         |
| GrantRead |     string     |  无    | 否           |         赋予被授权者读的权限。格式：id=" ",id=" "；当需要给子账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<SubUin>"，当需要给根账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<OwnerUin>"，例如：'id="qcs::cam::uin/123:uin/123", id="qcs::cam::uin/123:uin/456"'         |
| GrantWrite |     string     |  无    | 否           |         赋予被授权者写的权限。格式：id=" ",id=" "；当需要给子账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<SubUin>"，当需要给根账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<OwnerUin>"，例如：'id="qcs::cam::uin/123:uin/123", id="qcs::cam::uin/123:uin/456"'       |
| GrantFullControl |     string     |  无    | 否           |          赋予被授权者读写权限。格式：id=" ",id=" "；当需要给子账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<SubUin>"，当需要给根账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<OwnerUin>"，例如：'id="qcs::cam::uin/123:uin/123", id="qcs::cam::uin/123:uin/456"'         |


#### 示例

```php
#putBucketACL
try {
    $result = $cosClient->PutBucketAcl(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
        'Grants' => array(
            array(
                'Grantee' => array(
                    'DisplayName' => 'qcs::cam::uin/327874225:uin/327874225',
                    'ID' => 'qcs::cam::uin/327874225:uin/327874225',
                    'Type' => 'CanonicalUser',
                ),
                'Permission' => 'FULL_CONTROL',
            ),
            // ... repeated
        ),
        'Owner' => array(
            'DisplayName' => 'qcs::cam::uin/3210232098:uin/3210232098',
            'ID' => 'qcs::cam::uin/3210232098:uin/3210232098',
        ),));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```
### getBucketACL
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model getBucketACL(array $args = array());
```

#### 参数说明

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |



#### 示例
```php
#getBucketACL
try {
    $result = $cosClient->GetBucketAcl(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```
### putObjectACL
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model putObjectACL(array $args = array());
```

#### 参数说明
| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Key |     string     |  无    | 是            |         文件名称         |
| ACL      |     string     |  无    | 否           |         ACL权限控制         |
| GrantRead |     string     |  无    | 否           |         赋予被授权者读的权限。格式：id=" ",id=" "；当需要给子账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<SubUin>"，当需要给根账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<OwnerUin>"，例如：'id="qcs::cam::uin/123:uin/123", id="qcs::cam::uin/123:uin/456"'         |
| GrantWrite |     string     |  无    | 否           |         赋予被授权者写的权限。格式：id=" ",id=" "；当需要给子账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<SubUin>"，当需要给根账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<OwnerUin>"，例如：'id="qcs::cam::uin/123:uin/123", id="qcs::cam::uin/123:uin/456"'       |
| GrantFullControl |     string     |  无    | 否           |          赋予被授权者读写权限。格式：id=" ",id=" "；当需要给子账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<SubUin>"，当需要给根账户授权时，id="qcs::cam::uin/<OwnerUin>:uin/<OwnerUin>"，例如：'id="qcs::cam::uin/123:uin/123", id="qcs::cam::uin/123:uin/456"'         |

#### 示例
```php
#putObjectACL
try {
    $result = $cosClient->PutBucketAcl(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
        'Grants' => array(
            array(
                'Grantee' => array(
                    'DisplayName' => 'qcs::cam::uin/327874225:uin/327874225',
                    'ID' => 'qcs::cam::uin/327874225:uin/327874225',
                    'Type' => 'CanonicalUser',
                ),
                'Permission' => 'FULL_CONTROL',
            ),
            // ... repeated
        ),
        'Owner' => array(
            'DisplayName' => 'qcs::cam::uin/3210232098:uin/3210232098',
            'ID' => 'qcs::cam::uin/3210232098:uin/3210232098',
        ),));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```
### getObjectACL
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model getObjectACL(array $args = array());
```

#### 参数说明

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               | 
| Key|     string     |  无    | 是           |              文件名称               | 

#### 示例
```php
#getObjectACL
try {
    $result = $cosClient->getObjectAcl(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
        'Key' => '11'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```

### putBucketCors
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model putBucketCors(array $args = array());
```
#### 参数说明

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| CORSRules |     array |  无    | 是            |        CORS规则        |
| AllowedMethods |     array |  无    | 否           |         允许的 HTTP 操作，枚举值：GET，PUT，HEAD，POST，DELETE        |
| AllowedOrigins |     array |  无    | 否           |         允许的访问来源，支持通配符 * 格式为：协议://域名[:端口]如：http://www.qq.com       |
| AllowedHeaders |     array |  无    | 否           |          在发送 OPTIONS 请求时告知服务端，接下来的请求可以使用哪些自定义的 HTTP 请求头部，支持通配符 *        |
| ExposeHeaders |     array |  无    | 否           |         设置浏览器可以接收到的来自服务器端的自定义头部信息       |
| MaxAgeSeconds |     string     |  无    | 否           |         设置 OPTIONS 请求得到结果的有效期        |
| ID |     string     |  无    | 否           |         配置规则的 ID       |
#### 示例

```php
###putBucketCors
try {
    $result = $cosClient->putBucketCors(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
        // CORSRules is required
        'CORSRules' => array(
            array(
                'AllowedHeaders' => array('*',),
            // AllowedMethods is required
            'AllowedMethods' => array('Put', ),
            // AllowedOrigins is required
            'AllowedOrigins' => array('*', ),
            'ExposeHeaders' => array('*', ),
            'MaxAgeSeconds' => 1,
        ),
        // ... repeated
    ),
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```
### getBucketCors
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model getBucketCors(array $args = array());
```
#### 参数说明


| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               | 
#### 示例

```php
#getBucketCors
try {
    $result = $cosClient->getBucketCors(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```
### deleteBucketCors
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model deleteBucketCors(array $args = array());
```
#### 参数说明

* **params** (Object) ： 参数列表
  * Bucket —— (String) ： Bucket 名称   
#### 示例

```php
#deleteBucketCors
try {
    $result = $cosClient->deleteBucketCors(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```

### 复制对象
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model copyObject(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: | :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| CopySource      |     string     |  无    | 是          |         复制来源         |
| Key      |     string     |  无    | 是          |         对象名称       |

#### 示例

```php
#copyobject
try {
    $result = $cosClient->copyObject(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' => 'testbucket-125000000',
        // CopySource is required
        'CopySource' => 'lewzylu03-1252448703.cos.ap-guangzhou.myqcloud.com/tox.ini',
        // Key is required
        'Key' => 'string',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```

#Copy
try {
    $result = $cosClient->Copy($bucket = 'lewzylu01-1252448703',
        $key = 'string',
        $copysource = 'lewzylu02-1252448703.cos.ap-guangzhou.myqcloud.com/test1G',
        $options = array('VersionId'=>'MTg0NDY3NDI1NTk0MzUwNDQ1OTg'));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

### putBucketLifecycle
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model putBucketLifecycle(array $args = array());
```
#### 参数说明

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Rules  |     array |  无    | 是            |      设置对应的规则，包括 ID，Filter，Status，Expiration，Transition，NoncurrentVersionExpiration，NoncurrentVersionTransition，AbortIncompleteMultipartUpload      |
| ID |     string     |  无    | 否           |         配置规则的 ID       |
| Filter  |     array |  无    | 是          |         用于描述规则影响的 Object 集合        |
| Status  |     array |  无    | 是          |         设置 Rule 是否启用，可选值为 Enabled 或者 Disabled     |
| Expiration  |     array |  无    | 否           |         设置 Object 过期规则，可以指定天数 Days 或者指定日期 Date |
| Transition  |     array |  无    | 否           |         设置 Object 转换存储类型规则，可以指定天数 Days 或者指定日期 Date，StorageClass 可选 Standard_IA， Nearline       |
#### 示例

```php
#putBucketLifecycle
try {
    $result = $cosClient->putBucketLifecycle(array(
    //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
    'Bucket' => 'testbucket-125000000',
    // Rules is required
    'Rules' => array(
        array(
            'Expiration' => array(
                'Days' => 1,
            ),
            'ID' => 'id1',
            'Filter' => array(
                'Prefix' => 'documents/'
            ),
            // Status is required
            'Status' => 'Enabled',
            'Transition' => array(
                'Days' => 100,
                'StorageClass' => 'NEARLINE',
            ),
            // ... repeated
        ),
    )));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```
### getBucketLifecycle
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model getBucketLifecycle(array $args = array());
```
#### 参数说明


| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               | 
#### 示例

```php
#getBucketLifecycle
try {
    $result = $cosClient->getBucketLifecycle(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' =>'testbucket-125000000',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```
### deleteBucketLifecycle
#### 方法原型

```php
// 获取文件列表
public Guzzle\Service\Resource\Model deleteBucketLifecycle(array $args = array());
```
#### 参数说明
| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: |    :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               | 
#### 示例

```php
#deleteBucketLifecycle
try {
    $result = $cosClient->deleteBucketLifecycle(array(
        //bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
        'Bucket' =>'testbucket-125000000',
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}
```





### 获得object下载url

获得object带签名的下载url

#### 示例

```php
//获得object的下载url
//bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
$bucket =  'testbucket-125000000';
$key = 'hello.txt';
$region = 'cn-south';
$url = "/{$key}";
$request = $cosClient->get($url);
$signedUrl = $cosClient->getObjectUrl($bucket, $key, '+10 minutes');
```
### 使用临时密钥

```php
$cosClient = new Qcloud\Cos\Client(
    array(
        'region' => 'cn-south',
        'timeout' => ,
        'credentials'=> array(
            'appId' => '',
            'secretId'    => '',
            'secretKey' => '',
            'token' => '')));
```
### 恢复归档文件

#### 方法原型

```php
//  恢复归档文件
public Guzzle\Service\Resource\Model deleteObject(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: | :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Key      |     string     |  无    | 是           |         对象名称         |
| Days      |     integer |  无    | 是          |         保存时间        |
| Tier   |     string |  standard    | 否          |         恢复类型        |

#### 示例

```php
  try {
    $result = $cosClient->restoreObject(array(
        // Bucket is required
        'Bucket' => 'lewzylu02',
        // Objects is required
        'Key' => '11',
        'Days' => 7,
        'CASJobParameters' => array(
            'Tier' =>'Bulk'
        )
    ));
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}```

### 开启多版本

#### 方法原型

```php
// 开启多版本
public Guzzle\Service\Resource\Model putBucketVersioning(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: | :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Status   |     string     |  无    | 是           |               多版本状态              |

#### 示例

```php
#putBucketVersioning
try {
    $result = $cosClient->putBucketVersioning(
    array('Bucket' => 'lewzylu02',
    'Status' => 'Enabled')
    );
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}


```

```
### 获取bucket版本

#### 方法原型

```php
// 获取bucket版本
public Guzzle\Service\Resource\Model getBucketVersioning(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: | :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |

#### 示例

```php
try {
    $result = $cosClient->getBucketVersioning(
        array('Bucket' => 'lewzylu02',)
    );
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

```

```
### 打印各个版本的文件列表

#### 方法原型

```php
// 打印各个版本的文件列表
public Guzzle\Service\Resource\Model listObjectVersions(array $args = array());
```

#### 参数说明

$args是包含以下字段的关联数组：

| 字段名   |       类型     | 默认值 | 是否必填字段 |                  描述                  |
| :------: | :------------: | :--:   | :--------:   | :----------------------------------: |
| Bucket   |     string     |  无    | 是           |               bucket名称               |
| Delimiter      |     string     |  无    | 否          |         分隔符         |
| Marker      |     string     |  无    | 否          |         标记        |
| MaxKeys      |     int     |  无    | 否          |         最大对象个数         |
| Prefix      |     string     |  无    | 否           |         前缀         |

#### 示例

```php
try {
    $result = $cosClient->listObjectVersions(
        array('Bucket' => 'lewzylu02',
            'Prefix'=>'test1G')
    );
    print_r($result);
} catch (\Exception $e) {
    echo "$e\n";
}

```
