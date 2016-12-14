class NewController < ApplicationController
    def create
        @templates = JSON.parse(File.read('app/assets/templates/items.json'))

        unless params[:template].nil?
            @templateFileName = params[:template]
            @templateFileName.delete! '+'
            @templateParam = @templateFileName
            @masterTemplate = JSON.parse(File.read('app/assets/templates/master.json'))
            @template = JSON.parse(File.read('app/assets/templates/' << @templates['items'][@templateParam]))

        end
    end
end
