# 简介

MoneyConvertor 是专门对人民币进行大小写转换的类，该方法可以完美转换任何形式小写货币格式为人民币大写。

# 示例

| 编号  | 小写货币  | 大写货币 |
| :------------ |:---------------| :-----|
| 1   | ￥ 1.5 | 人民币(大写) 壹元伍角 |
| 2   | ￥ 50000       |   人民币(大写) 伍万元整 |
| 3   | ￥ 65001.05        |    人民币(大写) 陆万伍仟零壹元零伍分 |
| 4   | ￥ 101010101011.01        | 人民币(大写) 壹仟零壹拾亿壹仟零壹拾万壹仟零壹拾壹元零壹分|
| 5   | ￥ 1,999,999,999       |    人民币(大写) 壹拾玖亿玖仟玖佰玖拾玖万玖仟玖佰玖拾玖元整 |
| 6   | ￥ .5      |   人民币(大写) 伍角 |
| 7   | ￥ 1000.00     | 人民币(大写) 壹仟元整 |
| 8   | ￥ a.22    | 人民币(大写) 不是有效的货币数值 |

# 使用方式

```php
require __DIR__ . '/MoneyConvertor.php';
$mc = new MoneyConvertor();
//数字类型
echo $mc->convert(1000.00);
//字符串类型
echo $mc->convert('1.322');
//特殊字符串逗号分割类型
echo $mc->convert('100,000,000.00');
//特殊字符串无整数位类型
echo $mc->convert('.5');
```