-- TM18 Function
-- 141201.1429	first create script

CREATE SCHEMA IF NOT EXISTS public;

CREATE OR REPLACE FUNCTION public.tm18() RETURNS bigint AS $$
declare
result bigint;
begin
select mod(extract(year from current_timestamp) :: bigint, 100) * 10000000000000000
+extract(month from current_timestamp) :: bigint * 100000000000000
+ extract(day from current_timestamp) :: bigint * 1000000000000
+ extract(hour from current_timestamp) :: bigint * 10000000000
+ extract(minute from current_timestamp) :: bigint * 100000000
+ extract(second from current_timestamp) :: bigint * 1000000
+ mod((extract(milliseconds from current_timestamp)*1000)::bigint,1000000)::bigint
into result;
return result;
end;
$$ LANGUAGE plpgsql;

