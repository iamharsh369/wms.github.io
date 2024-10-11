DELIMITER $$ 
Create Trigger before_delete_user
Before delete on users
for each row 
begin
insert into `user_backup` (`id`,`first_name`,`last_name`,`email`) value (old.id,old.first_name,old.last_name,old.email);
end $$
DELIMITER ;