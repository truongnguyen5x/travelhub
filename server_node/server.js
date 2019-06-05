var io = require('socket.io')(6002)
console.log('Connected to port 6002')
io.on('error', function(socket){
	console.log('error')
})
io.on('connection', function(socket){
	console.log('Co nguoi vua ket noi ' + socket.id)
})
var Redis = require('ioredis')
var redis = new Redis(1000)
redis.psubscribe("*",function(error,count){
	//
})
redis.on('pmessage',function(partner,channel,message){
	console.log(channel)

	message = JSON.parse(message)
	console.log(message.data.comment)
	io.emit(channel+":"+message.event,message.data)
	console.log('Sent')
})