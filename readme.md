# 背景
```
SRP公司的財務每週結算工資，計算方式如下
```
```
- 時薪 200 元 (星期一到星期五，最多8小時）
- 加班時薪 350 元（星期一到星期五超過8小時的部份算加班，六日整天都算加班時數）
```

```
因為勞動局有規定每週工時不能超過60小時
如果有違反規定的話會有罰款
而且每週要把工時報告上傳給勞動局

這週星期三是 SOLID 國慶日
勞動局突然公佈這天工作的工資計算要把工時以兩倍計算
財務找了工程師調整了計算的方式，並且測試沒問題後上線了

幾天後，營運長突然收到了勞動局的罰款通知
才發現工時報告和打卡記錄的工時完全對不起來...
```
# 目標
參考 Clean Architecture 第 7 章 SRP

把 Employee 的 `工資計算` 和 `工時報表` 拆成 `PayCalculator` 和 `HourReporter`

避免因為 regularHours 計算方式不同互相影響

範例原始碼可以參考 https://github.com/MingJen/srp-exercise/blob/master/php/src/Employee.php

# 任務
1. 重構出 `PayCalculator` 和 `HourReporter` 並確認通過測試
2. 看能不能讓 regularHours 的計算只存在一個地方
