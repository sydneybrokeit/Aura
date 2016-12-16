class NewController < ApplicationController
    def create
        @templates = JSON.parse(File.read('app/assets/templates/items.json'))

        unless params[:template].nil?
            @templateFileName = params[:template]
            @templateFileName.delete! '+'
            @templateParam = @templateFileName
            @masterTemplate = JSON.parse(File.read('app/assets/templates/master.json'))
            @template = JSON.parse(File.read('app/assets/templates/' << @templates['items'][@templateParam]))
            fromTemplate(@template)

        end
    end

    def returnIfTooltip(name, template)
        if template && template['tooltips'] && template['tooltips'][name.downcase]

            @returnedTemplate.push('<p class="tooltiptext tooltip-right tooltip-extra">' + template['tooltips'][name.downcase] + '</p>')
          elsif template && template['tooltips'] && template['tooltips'][name]
                @returnedTemplate.push('<p class="tooltiptext tooltip-right tooltip-extra">' + template['tooltips'][name] + '</p>')
        end
    end

    def fromTemplate(_template)
        @returnedTemplate = []
        @masterTemplate['fields'].each do |field|
            ## Checks for the yield point in a template
            if field[0] == 'yield'
              @embeddedTemplate = _template
                unless @embeddedTemplate['fields'].nil?
                    @embeddedTemplate['fields'].each do |field|
                        ##
                        # field[0] will be the name of the object in the template, e.g. "Brand"
                        # field[1] will be the type of the object, e.g. "text"
                        ##
                        @returnedTemplate.push('<div class="tooltip form-option">')
                        returnIfTooltip(field[0],@embeddedTemplate)
                        @returnedTemplate.push('<label class="field-title">' + field[0] + ': </label>')
                        @returnedTemplate.push('<input type="' + field[1] + '" name="' + field[0] + '" class="' + field[0].downcase + '">')
                        @returnedTemplate.push('</div>')
                    end
                end

            ## Checks if it is a 'condition' field
            elsif field[1].respond_to?('each')
                @returnedTemplate.push('<div class="radio">')
                ##
                # field[0] will be the name of the object in the template, e.g. "Brand"
                # field[1] will be the type of the object, e.g. "text"
                ##

                ## Setting up variables that are useful for later goodness :D
                @selection = field[1]
                @title = field[0]
                @type = @selection['type']

                @returnedTemplate.push('<label class="field-title">' + @title + '</label>')
                @selection['options'].each do |field|
                    @returnedTemplate.push('<div class="tooltip radio-option">')
                    returnIfTooltip(field, @masterTemplate)

                    @returnedTemplate.push('<input type="' + @type + '" name="' + @title + '" class="' + field.downcase + '">' + field)
                    @returnedTemplate.push('</div>')
                end
                @returnedTemplate.push('</div>')
            else
                ## Fallback for semi-regular fields.
                @returnedTemplate.push('<div class="tooltip form-option">')
                @returnedTemplate.push('<label class="field-title">' + field[0] + ': </label>')
                returnIfTooltip(field[0], @masterTemplate)
                if field[0] == 'Notes'
                    @returnedTemplate.push('<textarea type="' + field[0].downcase + '" name="' + field[0] + '" class="' + field[0].downcase + '"></textarea>')
                else
                    @returnedTemplate.push('<input type="' + field[1] + '" name="' + field[0] + '" class="' + field[0].downcase + '">')
                end
                @returnedTemplate.push('</div>')
          end
        end
    end
end
