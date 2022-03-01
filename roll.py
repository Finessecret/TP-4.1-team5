# -*- coding: utf8 -*-

import discord 
import random
from discord.ext import commands

client = commands.Bot( command_prefix = '.')

@client.event 

async def on_ready():
	print( ' bot connected')


@client.command( pass_context = True)

async def clear(ctx, amount = 100):
	await ctx.channel.purge(limit = amount)


@client.command( pass_context = True)

async def roll(ctx):
	await ctx.channel.send(random.randint(0,100))


@client.command( pass_context = True)

async def coin(ctx):
	number = (random.randint(0, 1))
	if number == 0:
		await ctx.channel.send("Решка")
	elif number == 1:
		await ctx.channel.send("Орёл")

@client.command( pass_context = True)

async def im(ctx):
	array = ['красивый', 'ослепляющий', 'долбаёб', 'собака', 'идёшь гулять с Воропаевой', 'идёшь к Лёхе на хату', 'отдыхаешь в теплаке', 'проебёшь кактку в Доте xD', 'КУКОЛД', 'будешь в тильте', 'поедешь в армию', 'с мамой Тёмыча гулять идёшь', 'писал сидя', 'всё ещё девственник 8===D', 'умрёшь', 'ебать страшный', 'запускаешь танки', 'будешь сидеть в автозаке', 'должен купить Егору шаву', 'пристаёшь к 18-им девушкам, а завтра сидишь в СИЗО', 'Казах, а вчера был человеком', 'едешь в Балашиху', 'пишешь команду боту, а мог бы заняться делом', 'играешь в кс, а завтра видишь Коваля с Лерой', 'дрочил? а надо бы...', 'хоть раз отжался? а в армии будешь каждый день', 'идёшь на хату к Лёнчику, а потом тебя не берут в ГИТИС', 'гладил кота?', 'был на парах, неуч?', 'девочка! А впрочем, как и всегда..','смотрел гей порно, мы знаем', 'учишь международное право, а завтра говришь «заказ #17 готов!»', 'как старый дед', 'обоссышь ободок унитаза', 'встретишь любовь всей своей жизни', 'выглядишь как чмо, иди поспи', 'узнаешь какова моча на вкус))', 'пахнешь как портовая шлюха, морем и нежностью', 'сосать будешь?']
	await ctx.channel.send('Сегодня ты '+ array[random.randint(0,39)])

@client.command( pass_context = True)

async def evg(ctx):
	array = ['сходи с Егором в пассаж', 'опять бабкину пенсию проебал?', 'пора выходить из тилта', 'хочу от тебя детей(нет)', 'отправь мне любовную песню ',]
	await ctx.channel.send('Женёк  '+array[random.randint(0,4)])






client.run('ODMyNjY5NTIyNjk5ODc4NDEx.YHnJ7A.FPMkVofV56Y77LeCD0UKOMZVveY')