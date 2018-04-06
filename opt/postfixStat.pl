#!/usr/bin/perl 
# utility for logs into mysql

use strict;
use warnings;
use diagnostics;
use IO::Handle;
use 5.010;
use Time::Piece;
use DBI;

my $database = 'audit';
my $host = 'localhost';
my $dbuser = 'audit';
my $dbpass = 'passpass';
my $port = '3306';
my $debug = 1;
my $line;
my $time;
my $prog;
my $text;
my $timedt;
my $user;
my $ip;
my $from;
my $to;
my $event;
my $pass;
my $auth;
my $id;
my $id2;
my $client;
my $orclient;
my $orto;
my $status;
my $msg;
my $sasl;

my $dsn = "DBI:mysql:$database:$host:$port";
my $dbh = DBI->connect($dsn, $dbuser, $dbpass);

# get STDIN and split it into three parts

while (defined($line = <STDIN>)) {
	($time, $prog, $text) = ($line =~ m/(\d+)\s+(\S+)\s+(.*)/x);

	# convert UNIXTIME
	$timedt = localtime($time)->strftime('%F %T');
	
	# parse interesting dovecot logs
	if ($prog =~ /^dovecot/) {
		# user is not found
		if ($text =~ /: unknown user/) {
			$text =~ m/sql\((.*?)(,|\):)/g;
			$user = $1;
			if ($text =~ m/\G(.*?),/g) {$ip = $1;} else {$ip = "none";}
			$pass = "unknown_user";
			$auth = 0;
			my $sql = "insert into dovecot values (?,?,?,?,?)";
			my $exsql = $dbh->prepare($sql);
			$exsql->execute($timedt,$user,$ip,$pass,$auth);
			if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
				print LogFile "$timedt $user $ip $pass $auth dovecot mstat \n";
				close(LogFile);
			}
		# incorrect password
		} elsif ($text =~ /\): MD5\(/) {
			$text =~ m/sql\((.*?),/g;
                        $user = $1;
                        $text =~ m/\G(.*?)(,|\):)/g;
                        $ip = $1;
			$text =~ m/MD5\((.*?)\) !/g;
                        $pass = $1;
                        $auth = 0;
			my $sql = "insert into dovecot values (?,?,?,?,?)";
                        my $exsql = $dbh->prepare($sql);
                        $exsql->execute($timedt,$user,$ip,$pass,$auth);
                        if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $user $ip $pass $auth dovecot mstat \n";
                        	close(LogFile);
			}
		# user authorized
		} elsif ($text =~ /imap-login: Login:/) {
			$text =~ m/user=<(.*?)>/g;
                        $user = $1;
                        $text =~ m/rip=(.*?),/g;
                        $ip = $1;
                        $pass = "none";
                        $auth = 1;
			my $sql = "insert into dovecot values (?,?,?,?,?)";
                        my $exsql = $dbh->prepare($sql);
                        $exsql->execute($timedt,$user,$ip,$pass,$auth);
                        if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $user $ip $pass $auth dovecot mstat \n";
                        	close(LogFile);
			}
		}
	# parse the postfix smtpd logs
	} if ($prog =~ /^postfix\/smtpd/) {
		# rejected letters
		if ($text =~ /reject: /) {
			$text =~ m/from\s\S+\[(.*?)\]:/g;
                        $ip = $1;
			$text =~ m/\G(.*?);/g;
                        $event = $1;
			$text =~ m/from=<(.*?)>/g;
                        $from = $1;
			$text =~ m/to=<(.*?)>/g;
                        $to = $1;
			my $sql = "insert into reject values (?,?,?,?,?)";
                        my $exsql = $dbh->prepare($sql);
                        $exsql->execute($timedt,$from,$to,$ip,$event);
			if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt reject $ip from $from to $to $event smtpd mstat \n";
                        	close(LogFile);
			}
		# logs with orig_client
		} elsif ($text =~ /orig_client=/) {
			$text =~ m/^(.*?):/g;
                        $id = $1;
			$text =~ m/orig_queue_id=(.*?),/g;
			$id2 = $1;
			$text =~ m/orig_client=\S+\[(.*?)\]/g;
			$orclient = $1;
			my $sql = "update postfix set `stopdate`=?,`id2`=?,`ip2`=? where `id`=?";
                        my $exsql = $dbh->prepare($sql);
                        $exsql->execute($timedt,$id,$client,$id2);
			if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $id $id2 orig_client $orclient smtpd mstat \n";
                        	close(LogFile);
			}
		# logs with client and authorized sender
		} elsif (($text =~ /client=/) and ($text =~ /sasl_username=/)) {
                        $text =~ m/^(.*?):/g;
                        $id = $1;
                        $text =~ m/client=\S+\[(.*?)\]/g;
                        $client = $1;
			$text =~ m/sasl_username=(.*?)$/g;
                        $sasl = $1;
			my $sql = "insert into postfix (`logdate`,`stopdate`,`id`,`ip`,`user`) values (?,?,?,?,?)";
                        my $exsql = $dbh->prepare($sql);
                        $exsql->execute($timedt,$timedt,$id,$client,$sasl);
                        if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $id client $client sasl_username $sasl smtpd mstat \n";
                        	close(LogFile);
			}
		# logs with client
		} elsif ($text =~ /client=/) {
			$text =~ m/^(.*?):/g; 
                        $id = $1;
                        $text =~ m/client=\S+\[(.*?)\]/g;
                        $client = $1;
                        my $sql = "insert into postfix (`logdate`,`stopdate`,`id`,`ip`) values (?,?,?,?)";
                        my $exsql = $dbh->prepare($sql);
                        $exsql->execute($timedt,$timedt,$id,$client);
                        if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $id client $client smtpd mstat \n";
                        	close(LogFile);
			}
		}
	# parse the postfix smtp logs
	} elsif ($prog =~ /^postfix\/smtp/) {
		if (($text =~ /orig_to/) and ($text =~ /queued as/)) {
			$text =~ m/^(.*?):/g;
                        $id = $1;
			$text =~ m/to=<(.*?)>/g;
                        $to = $1;
			$text =~ m/orig_to=<(.*?)>/g;
                        $orto = $1;
			$text =~ m/status=(.*?)\s\(/g;
                        $status = $1;
			$text =~ m/queued\sas\s(.*?)\)/g;
			$id2 = $1;
			my $sql = "update postfix set `stopdate`=?,`orig_to`=?,`to`=concat(`to`,?),`status`=concat(`status`,?) where `id`=? or `id2`=?";
                        my $exsql = $dbh->prepare($sql);
			$to = $to." ";
			$status = $status." ";
                        $exsql->execute($timedt,$orto,$to,$status,$id,$id);
			if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $id $id2 to $to orig_to $orto status $status smtp mstat \n";
                        	close(LogFile);
			} 
		} elsif ($text =~ /orig_to/) {
			$text =~ m/^(.*?):/g;
                        $id = $1;
                        $text =~ m/to=<(.*?)>/g;
                        $to = $1;
                        $text =~ m/orig_to=<(.*?)>/g;
                        $orto = $1;
                        $text =~ m/status=(.*?)\s\(/g;
                        $status = $1;
			my $sql = "update postfix set `stopdate`=?,`orig_to`=?,`to`=concat(`to`,?),`status`=concat(`status`,?) where `id`=? or `id2`=?";
                        my $exsql = $dbh->prepare($sql);
                        $to = $to." ";
			$status = $status." ";
                        $exsql->execute($timedt,$orto,$to,$status,$id,$id);
                        if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $id to $to orig_to $orto status $status smtp mstat \n";
                        	close(LogFile);
			}
		} elsif ($text =~ /queued as/) {
                        $text =~ m/^(.*?):/g;
                        $id = $1;
                        $text =~ m/to=<(.*?)>/g;
                        $to = $1;
                        $text =~ m/status=(.*?)\s\(/g;
                        $status = $1;
                        $text =~ m/queued\sas\s(.*?)\)/g;
                        $id2 = $1;
			my $sql = "update postfix set `stopdate`=?,`to`=concat(`to`,?),`status`=concat(`status`,?) where `id`=? or `id2`=?";
                        my $exsql = $dbh->prepare($sql);
                        $to = $to." ";
			$status = $status." ";
                        $exsql->execute($timedt,$to,$status,$id,$id);
                        if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $id $id2 to $to status $status smtp mstat \n";
                        	close(LogFile);
			}
                }
	} if ($prog =~ /^postfix\/qmgr/) {
		if ($text =~ /from=/) {
			$text =~ m/^(.*?):/g;
                        $id = $1;
                        $text =~ m/from=<(.*?)>/g;
                        $from = $1;
			my $sql = "update postfix set `stopdate`=?,`from`=? where `id`=? or `id2`=?";
                        my $exsql = $dbh->prepare($sql);
                        $exsql->execute($timedt,$from,$id,$id);
			if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $id from $from qmgr mstat \n";
                        	close(LogFile);
			}
		}
	} if ($prog =~ /^postfix\/cleanup/) {
		if ($text =~ /message-id=/) {
			$text =~ m/^(.*?):/g;
                        $id = $1;
                        $text =~ m/message-id=<(.*?)>/g;
                        $msg = $1;
			my $sql = "update postfix set `stopdate`=?,`msgid`=? where `id`=? or `id2`=?";
                        my $exsql = $dbh->prepare($sql);
                        $exsql->execute($timedt,$msg,$id,$id);
                        if (debug) {
				open(LogFile,">> /opt/postfixStat.log");
                        	print LogFile "$timedt $id msg_id $msg cleanup mstat \n";
                        	close(LogFile);
			}
		}
	}

	if (debug) {
		open(LogFile,">> /opt/postfixStat.log");
        	print LogFile "$timedt $prog $text \n";
       		close(LogFile);
	}
}
