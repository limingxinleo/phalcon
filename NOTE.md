## 更新数据的同时获取数据的存储过程
~~~
CREATE PROCEDURE getCardID( IN in_date INT, IN in_type INT)
BEGIN
SET @update_id := 0;
UPDATE cards SET status = 1, cardid = (SELECT @update_id := cardid)
WHERE `date` = in_date AND `type` = in_type AND `status` = 0 ORDER BY sortid LIMIT 1;
SELECT @update_id AS cardid;
END;
~~~
## GIT 保存用户名密码到本地
~~~
git config --global credential.helper store
~~~